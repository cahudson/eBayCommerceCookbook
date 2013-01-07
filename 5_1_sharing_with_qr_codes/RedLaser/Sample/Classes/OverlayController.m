/*******************************************************************************
	OverlayController.m
	
	This is the view controller for the single scan overlay. This controller
	is a sub-controller of the RedLaser SDK's BarcodePickerController, and 
	is presented when the BarcodePickerController is shown--if we are set as 
	the overlay of the BarcodePickerController, that is.
	
	Chall Fry
	February 2012
	Copyright (c) 2012 eBay Inc. All rights reserved.	
*/

#import "OverlayController.h"
#if defined(RL_LOCALIZED)
#import "Localization.h"
#endif

@implementation OverlayController

- (void) dealloc 
{
	if ([self isViewLoaded])
		[self viewDidUnload];
		
	[super dealloc];
}

- (void) viewDidLoad 
{
    [super viewDidLoad];
	
	// Create active region rectangle
	rectLayer = [[CAShapeLayer layer] retain];
	rectLayer.fillColor = [[UIColor colorWithRed:1.0 green:0.0 blue:0.0 alpha:0.2] CGColor];
	rectLayer.strokeColor = [[UIColor whiteColor] CGColor];
	rectLayer.lineWidth = 3;
	[self.view.layer addSublayer:rectLayer];
			
	// Prepare an audio session
	AudioSessionInitialize(NULL, NULL, NULL, NULL);
	AudioSessionSetActive(TRUE);

	// Load up the beep sound
	UInt32 flag = 0;
	float aBufferLength = 1.0; // In seconds
	NSURL *soundFileURL = [NSURL fileURLWithPath:[[NSBundle mainBundle] 
			pathForResource:@"beep" ofType:@"wav"] isDirectory:NO]; 
	AudioServicesCreateSystemSoundID((CFURLRef) soundFileURL, &scanSuccessSound);
	OSStatus error = AudioServicesSetProperty(kAudioServicesPropertyIsUISound,
			sizeof(UInt32), &scanSuccessSound, sizeof(UInt32), &flag);
	error = AudioSessionSetProperty(kAudioSessionProperty_PreferredHardwareIOBufferDuration, 
			sizeof(aBufferLength), &aBufferLength);
}

- (void) viewDidUnload 
{		
	AudioServicesDisposeSystemSoundID(scanSuccessSound);
	AudioSessionSetActive(FALSE);
	
	[rectLayer release];
	rectLayer = nil;
	
	[textCue release];
	textCue = nil;
	[cancelButton release];
	cancelButton = nil;
	[frontButton release];
	frontButton = nil;
	[flashButton release];
	flashButton = nil;
	[redlaserLogo release];
	redlaserLogo = nil;
	
	[super viewDidUnload];
}

- (void) viewWillAppear:(BOOL)animated
{
	// Set the initial scan orientation
	[self setLayoutOrientation:self.parentPicker.orientation];
	
	if ([self.parentPicker hasFlash]) 
	{
		[flashButton setEnabled:YES];
		[flashButton setStyle:UIBarButtonItemStyleBordered];
		[self.parentPicker turnFlash:NO];
	} else
	{
		[flashButton setEnabled:NO];
	}

	textCue.text = @"";
	viewHasAppeared = NO;
}

- (void)viewDidAppear:(BOOL)animated
{
	viewHasAppeared = YES;
}

- (void) barcodePickerController:(BarcodePickerController*)picker statusUpdated:(NSDictionary*)status
{
	// In the status dictionary:
	
	// "FoundBarcodes" key is a NSSet of all discovered barcodes this scan session
	// "NewFoundBarcodes" is a NSSet of barcodes discovered in the most recent pass.
		// When a barcode is found, it is added to both sets. The NewFoundBarcodes
		// set is cleaned out each pass.
	
	// "Guidance" can be used to help guide the user through the process of discovering
	// a long barcode in sections. Currently only works for Code 39.
	
	// "Valid" is TRUE once there are valid barcode results.
	// "InRange" is TRUE if there's currently a barcode detected the viewfinder. The barcode
	//		may not have been decoded yet. It is possible for barcodes to be found without
	// 		InRange ever being set.
	
	
	// Make the RedLaser stripe more vivid when Barcode is in Range.
	BOOL inRange = [(NSNumber*)[status objectForKey:@"InRange"] boolValue];
	if (inRange)
	{
		rectLayer.strokeColor = [[UIColor greenColor] CGColor];
	}
	else
	{
		rectLayer.strokeColor = [[UIColor whiteColor] CGColor];
	}
	
	// Beep when we find a new code
	NSSet *newFoundBarcodes = [status objectForKey:@"NewFoundBarcodes"];
	if ([newFoundBarcodes count])
	{
		AudioServicesPlayAlertSound(scanSuccessSound);
	}
	
	// Exit if we've found a code, and the view has fully appeared.
	// The viewHasAppeared check is to work around a bug with modal views not going away
	// if dismissed while they're still animating into place.
	NSSet *foundBarcodes = [status objectForKey:@"FoundBarcodes"];
	if ([foundBarcodes count] && viewHasAppeared)
	{
		[self.parentPicker doneScanning];
	}
	
	int guidanceLevel = [[status objectForKey:@"Guidance"] intValue];
	if (guidanceLevel == 1)
	{
		textCue.text = @"Try moving the camera close to each part of the barcode";
	} else if (guidanceLevel == 2)
	{
		textCue.text = [status objectForKey:@"PartialBarcode"];
	} else 
	{
		textCue.text = @"";
	}
}

#pragma mark Button Handlers

- (IBAction) cancelButtonPressed
{
	[self.parentPicker doneScanning];
}

- (IBAction) flashButtonPressed 
{
	if ([flashButton style] == UIBarButtonItemStyleBordered) 
	{
		[flashButton setStyle:UIBarButtonItemStyleDone];
		[self.parentPicker setTorchState:YES];
	} else 
	{
		[flashButton setStyle:UIBarButtonItemStyleBordered];
		[self.parentPicker setTorchState:NO];
	}
}

- (IBAction) rotateButtonPressed
{
	// Swap the UI orientation. 
	if (self.parentPicker.orientation == UIImageOrientationUp)
		[self setLayoutOrientation:UIImageOrientationRight];
	else 
		[self setLayoutOrientation:UIImageOrientationUp];
}

// Toggles between front and back cameras
- (IBAction) cameraToggleButtonPressed
{
	if (self.parentPicker.useFrontCamera)
	{
		[frontButton setStyle:UIBarButtonItemStyleBordered];
		self.parentPicker.useFrontCamera = false;
	} else
	{
		[frontButton setStyle:UIBarButtonItemStyleDone];
		self.parentPicker.useFrontCamera = true;
	}
}

// The SDK has an Active Region property, which is a rectangle in the camera
// view that is searched more thoroughly for barcodes. Although barcodes may
// still be found outside of this region, the active region is where the most
// intense searching is performed. It is the job of the application to direct
// the user to place barcodes in the active region to maximize performance.

// Your application's overlay UI should give users a target of some sort, 
// pointing out where they should position the barcode in the preview for best
// performance. The Active Region property's purpose is so you can tell the SDK
// to look for a barcode in the same place where you're telling the user to hold
// the barcode. 

// Similarly, the SDK's orientation property refers to the orientation of a barcode
// relative to the device--NOT to the device's orientation. The SDK will spend
// more resources looking for barcodes in this orientation than in other orientations.
// Therefore, it's helpful to guide users to hold barcodes up to the camera in the
// orientation that matches the value of this property. 

- (void) setLayoutOrientation:(UIImageOrientation) newOrientation
{
	CGRect 				activeRegionRect;
	CGAffineTransform 	transform;		
	CGMutablePathRef 	path = CGPathCreateMutable();
		
	if (newOrientation == UIImageOrientationUp)
	{
		activeRegionRect = CGRectMake(0, 100, 320, 250);
		transform = CGAffineTransformMakeRotation(0);	
		CGPathAddRect(path, NULL, activeRegionRect);
	} else if (newOrientation == UIImageOrientationRight)
	{
		activeRegionRect = CGRectMake(100, 0, 120, 436);
		transform = CGAffineTransformMakeRotation(M_PI_2); // 90 degree rotation
		
		// This makes a rectangular path that starts in the upper right instead of
		// upper left. This makes the animation 'rotate' the rect.
		CGPathMoveToPoint(path, nil, CGRectGetMaxX(activeRegionRect), CGRectGetMinY(activeRegionRect));
		CGPathAddLineToPoint(path, nil, CGRectGetMaxX(activeRegionRect), CGRectGetMaxY(activeRegionRect));
		CGPathAddLineToPoint(path, nil, CGRectGetMinX(activeRegionRect), CGRectGetMaxY(activeRegionRect));
		CGPathAddLineToPoint(path, nil, CGRectGetMinX(activeRegionRect), CGRectGetMinY(activeRegionRect));
		CGPathCloseSubpath (path);
		
		// If you use this path instead, the rect will resize when animated.
		//	CGPathAddRect(path, NULL, activeRegionRect);

	}
	// Note: Could handle other UIImageOrientations here as well, but the 'rotate' button
	// is just a toggle.
	
	// Rotate the red rectangle to the new layout position
	CABasicAnimation *targetRectReshaper = [CABasicAnimation animationWithKeyPath:@"path"];
	targetRectReshaper.duration = 0.5;
	targetRectReshaper.fillMode = kCAFillModeForwards;
	[targetRectReshaper setRemovedOnCompletion:NO];
	[targetRectReshaper setDelegate:self];
	targetRectReshaper.toValue = (id) path;
	[rectLayer addAnimation:targetRectReshaper forKey:@"animatePath"];
	CGPathRelease(path);

	// Also rotate the RedLaser logo
	[UIView beginAnimations:@"setScanningOrientation" context:nil];
	[UIView setAnimationCurve: UIViewAnimationCurveLinear];
	[UIView setAnimationDuration: 0.5];
	redlaserLogo.transform = transform;
	[UIView commitAnimations];

	// Set the SDK's active region and orientation to match our new target rectangle.
	[self.parentPicker setActiveRegion:activeRegionRect];
	self.parentPicker.orientation = newOrientation;
}

- (void) animationDidStop:(CABasicAnimation *)theAnimation finished:(BOOL)flag
{
	[rectLayer setPath:(CGPathRef) theAnimation.toValue];
	[rectLayer removeAnimationForKey:[theAnimation keyPath]];
}


@end
