/*******************************************************************************
	MultiScanOverlayController.m

	This is the view controller for the multiple scan overlay. This controller
	is a sub-controller of the RedLaser SDK's BarcodePickerController, and 
	is presented when the BarcodePickerController is shown--if we are set as 
	the overlay of the BarcodePickerController, that is.
	
	The MultiScanOverlay uses a different UI than the single scan overlay,
	mostly to show what's possible. Other than that, the major difference
	between this and the single scan UI is that this UI doesn't exit until
	the done button is clicked.
	
	Chall Fry
	February 2012
	Copyright (c) 2012 eBay Inc. All rights reserved.	
*/

#import "MultiScanOverlayController.h"

@implementation MultiScanOverlayController

- (id) init
{
	if (self = [super init])
	{
		barcodeTableData = [[NSMutableArray alloc] init];
	}
	
	return self;
}

- (void) dealloc 
{
	if ([self isViewLoaded])
		[self viewDidUnload];
		
	[barcodeTableData release];
	
	[super dealloc];
}

- (void) viewDidLoad 
{
    [super viewDidLoad];
				
	// Prepare an audio session
	AudioSessionInitialize(NULL, NULL, NULL, NULL);
	AudioSessionSetActive(TRUE);

	// Create target line object, and set its initial path
	targetLine = [[CAShapeLayer layer] retain];
	targetLine.fillColor = [[UIColor colorWithRed:1.0 green:0.0 blue:0.0 alpha:0.5] CGColor];
	targetLine.strokeColor = [[UIColor colorWithRed:1.0 green:0.0 blue:0.0 alpha:0.5] CGColor];
	targetLine.lineWidth = 3;
	[self.view.layer addSublayer:targetLine];
	CGMutablePathRef path = CGPathCreateMutable();
	CGRect activeRegionRect = CGRectMake(0, 100, 320, 250);
	CGPathMoveToPoint(path, nil, CGRectGetMinX(activeRegionRect) + 40, CGRectGetMidY(activeRegionRect));
	CGPathAddLineToPoint(path, nil, CGRectGetMaxX(activeRegionRect) - 40, CGRectGetMidY(activeRegionRect));
	targetLine.path = path;
	CGPathRelease(path);
	self.parentPicker.orientation = UIImageOrientationUp;

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
			
	[[doneButton layer] setCornerRadius:18.0f];
	[[doneButton layer] setMasksToBounds:YES];
	[[doneButton layer] setBorderWidth:1.0f];

	[[torchButton layer] setCornerRadius:18.0f];
	[[torchButton layer] setMasksToBounds:YES];
	[[torchButton layer] setBorderWidth:1.0f];

	[[rotateButton layer] setCornerRadius:18.0f];
	[[rotateButton layer] setMasksToBounds:YES];
	[[rotateButton layer] setBorderWidth:1.0f];

}

- (void) viewDidUnload 
{
	if (scanSuccessSound)
	{
		AudioServicesDisposeSystemSoundID(scanSuccessSound);
		AudioSessionSetActive(FALSE);
		scanSuccessSound = 0;
	}
		
	[torchButton release];
	torchButton = nil;
	[doneButton release];
	doneButton = nil;
	[rotateButton release];
	rotateButton = nil;
	[foundBarcodesTable release];
	foundBarcodesTable = nil;
	[redlaserLogo release];
	redlaserLogo = nil;
	
	[targetLine release];
	targetLine = nil;

	[super viewDidUnload];
}

- (void) viewWillAppear:(BOOL)animated
{
	if ([self.parentPicker hasFlash]) 
	{
		[torchButton setEnabled:YES];
		[torchButton setSelected:FALSE];
		[torchButton setBackgroundColor:[UIColor lightGrayColor]];
		[self.parentPicker turnFlash:NO];
	} else
	{
		[torchButton setEnabled:NO];
	}
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
	
	// Beep when we find a new code, and add the code to our table for immediate display
	NSSet *newFoundBarcodes = [status objectForKey:@"NewFoundBarcodes"];
	if ([newFoundBarcodes count])
	{
		AudioServicesPlayAlertSound(scanSuccessSound);
		[barcodeTableData addObjectsFromArray:[newFoundBarcodes allObjects]];
		[foundBarcodesTable reloadData];
	}
}

#pragma mark Button Handlers

- (IBAction) doneButtonPressed
{
	[self.parentPicker doneScanning];
}

- (IBAction) torchButtonPressed 
{
	if ([torchButton isSelected]) 
	{
		[torchButton setSelected:FALSE];
		[torchButton setBackgroundColor:[UIColor lightGrayColor]];
		[self.parentPicker setTorchState:NO];
	} else 
	{
		[torchButton setSelected:TRUE];
		[torchButton setBackgroundColor:[UIColor whiteColor]];
		[self.parentPicker setTorchState:YES];
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

- (IBAction) rotatePressed
{
	CGRect 				activeRegionRect;
	UIImageOrientation	previousOrientation = self.parentPicker.orientation;
	UIImageOrientation	newOrientation;
	CGMutablePathRef 	path = CGPathCreateMutable();
		
	if (previousOrientation == UIImageOrientationUp)
	{
		activeRegionRect = CGRectMake(100, 0, 120, 436);
		newOrientation = UIImageOrientationRight;
		CGPathMoveToPoint(path, nil, CGRectGetMidX(activeRegionRect), CGRectGetMinY(activeRegionRect) + 80);
		CGPathAddLineToPoint(path, nil, CGRectGetMidX(activeRegionRect), CGRectGetMaxY(activeRegionRect) - 80);
	} else if (previousOrientation == UIImageOrientationRight)
	{
		activeRegionRect = CGRectMake(0, 100, 320, 250);
		newOrientation = UIImageOrientationDown;
		CGPathMoveToPoint(path, nil, CGRectGetMaxX(activeRegionRect) - 40, CGRectGetMidY(activeRegionRect));
		CGPathAddLineToPoint(path, nil, CGRectGetMinX(activeRegionRect) + 40, CGRectGetMidY(activeRegionRect));
	} else if (previousOrientation == UIImageOrientationDown)
	{
		activeRegionRect = CGRectMake(100, 0, 120, 436);
		newOrientation = UIImageOrientationLeft;
		CGPathMoveToPoint(path, nil, CGRectGetMidX(activeRegionRect), CGRectGetMaxY(activeRegionRect) - 80);
		CGPathAddLineToPoint(path, nil, CGRectGetMidX(activeRegionRect), CGRectGetMinY(activeRegionRect) + 80);
	} else if (previousOrientation == UIImageOrientationLeft)
	{
		activeRegionRect = CGRectMake(0, 100, 320, 250);
		newOrientation = UIImageOrientationUp;
		CGPathMoveToPoint(path, nil, CGRectGetMinX(activeRegionRect) + 40, CGRectGetMidY(activeRegionRect));
		CGPathAddLineToPoint(path, nil, CGRectGetMaxX(activeRegionRect) - 40, CGRectGetMidY(activeRegionRect));
	}
	
	// Rotate the red rectangle to the new layout position
	CABasicAnimation *targetLineReshaper = [CABasicAnimation animationWithKeyPath:@"path"];
	targetLineReshaper.duration = 0.5;
	targetLineReshaper.fillMode = kCAFillModeForwards;
	[targetLineReshaper setRemovedOnCompletion:NO];
	[targetLineReshaper setDelegate:self];
	targetLineReshaper.toValue = (id) path;
	[targetLine addAnimation:targetLineReshaper forKey:@"animatePath"];
	CGPathRelease(path);
	
	// Animate the change to the logo
	[UIView beginAnimations:@"setScanningOrientation" context:nil];
	[UIView setAnimationCurve: UIViewAnimationCurveLinear ];
	[UIView setAnimationDuration: 0.5];
	redlaserLogo.transform = CGAffineTransformRotate(redlaserLogo.transform, M_PI_2);
	[UIView commitAnimations];

	// Set the SDK's active region and orientation to match our new target rectangle.
	[self.parentPicker setActiveRegion:activeRegionRect];
	self.parentPicker.orientation = newOrientation;
	
}

- (void) animationDidStop:(CABasicAnimation *)theAnimation finished:(BOOL)flag
{
	[targetLine setPath:(CGPathRef) theAnimation.toValue];
	[targetLine removeAnimationForKey:[theAnimation keyPath]];
}


#pragma mark Table View Data Source

- (NSInteger) numberOfSectionsInTableView:(UITableView *)tableView
{
	return 1;
}

- (NSInteger) tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{	
	return [barcodeTableData count];
}

- (UITableViewCell *) tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
	UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:@"BarcodeResult"];
    if (cell == nil) 
	{
        cell = [[[UITableViewCell alloc] initWithStyle:UITableViewCellStyleValue1 
				reuseIdentifier:@"TransparentResultOverlay"] autorelease];
        cell.selectionStyle = UITableViewCellSelectionStyleNone;
		cell.textLabel.textColor = [UIColor whiteColor];
		
    }
	
	// Get the barcodeResult that has the data backing this cell
	BarcodeResult *barcode = [barcodeTableData objectAtIndex:[barcodeTableData count] - indexPath.row - 1];

	// Set the text of the cell to the first 20 characters of the string
	if ([barcode.barcodeString length] > 20)
		cell.textLabel.text = [[barcode.barcodeString substringToIndex:20]
				stringByAppendingString:@"…"];
	else
    	cell.textLabel.text = barcode.barcodeString;

	
	switch (barcode.barcodeType) 
	{
		case kBarcodeTypeEAN13: cell.detailTextLabel.text = @"EAN-13"; break;
		case kBarcodeTypeEAN8: cell.detailTextLabel.text = @"EAN-8"; break;
		case kBarcodeTypeUPCE: cell.detailTextLabel.text = @"UPC-E"; break;
		case kBarcodeTypeEAN5: cell.detailTextLabel.text = @"EAN-5"; break;
		case kBarcodeTypeEAN2: cell.detailTextLabel.text = @"EAN-2"; break;
		case kBarcodeTypeSTICKY: cell.detailTextLabel.text = @"Stickybits"; break;
		case kBarcodeTypeCODE39: cell.detailTextLabel.text = @"Code 39"; break;
		case kBarcodeTypeCODE128: cell.detailTextLabel.text = @"Code 128"; break;
		case kBarcodeTypeITF: cell.detailTextLabel.text = @"ITF"; break;
		case kBarcodeTypeCodabar: cell.detailTextLabel.text = @"Codabar"; break;
		case kBarcodeTypeQRCODE: cell.detailTextLabel.text = @"QR Code"; break;
		case kBarcodeTypeDATAMATRIX: cell.detailTextLabel.text = @"Datamatrix"; break;
		default: cell.detailTextLabel.text = @""; break;
	}
	
    return cell;
}

- (CGFloat) tableView:(UITableView *)tableView heightForRowAtIndexPath:(NSIndexPath *)indexPath 
{
	return 22;
}


@end
