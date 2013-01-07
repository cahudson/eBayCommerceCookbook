/*******************************************************************************
	OverlayController.h
	
	This is the view controller for the single scan overlay. This controller
	is a sub-controller of the RedLaser SDK's BarcodePickerController, and 
	is presented when the BarcodePickerController is shown--if we are set as 
	the overlay of the BarcodePickerController, that is.
	
	Chall Fry
	February 2012
	Copyright (c) 2012 eBay Inc. All rights reserved.	
*/
#pragma once

#import <UIKit/UIKit.h>
#import "RedLaserSDK.h"
#import "AudioToolbox/AudioServices.h"
#import <QuartzCore/QuartzCore.h>

@interface OverlayController : CameraOverlayViewController
{
	
	IBOutlet UILabel 			*textCue;
	IBOutlet UIBarButtonItem 	*cancelButton;	
	IBOutlet UIBarButtonItem 	*frontButton;
	IBOutlet UIBarButtonItem 	*flashButton;
	IBOutlet UIImageView 		*redlaserLogo;
	
	BOOL 						viewHasAppeared;
	
	SystemSoundID 				scanSuccessSound;
	
	CAShapeLayer 				*rectLayer;
}

- (IBAction) cancelButtonPressed;
- (IBAction) flashButtonPressed;
- (IBAction) rotateButtonPressed;
- (IBAction) cameraToggleButtonPressed;

- (void) setLayoutOrientation:(UIImageOrientation) newOrientation;
@end
