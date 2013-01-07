/*******************************************************************************
	RLScanOptionsController.h
	
	Switches to enable individual barcode symbologies.
	
	Chall Fry
	February 2012
	Copyright (c) 2012 eBay Inc. All rights reserved.	
*/
#pragma once

#import <UIKit/UIKit.h>
#import "RedLaserSDK.h"

@interface RLScanOptionsController : UIViewController
{
	BarcodePickerController	*picker;
	
}
@property (retain, nonatomic) IBOutlet UIScrollView *optionScrollerView;
@property (retain, nonatomic) IBOutlet UIView 		*optionContainerView;

@property (retain, nonatomic) IBOutlet UISwitch *enableEAN13Switch;
@property (retain, nonatomic) IBOutlet UISwitch *enableEAN8Switch;
@property (retain, nonatomic) IBOutlet UISwitch *enableUPCESwitch;
@property (retain, nonatomic) IBOutlet UISwitch *enableEAN5Switch;
@property (retain, nonatomic) IBOutlet UISwitch *enableEAN2Switch;
@property (retain, nonatomic) IBOutlet UISwitch *enableCode128Switch;
@property (retain, nonatomic) IBOutlet UISwitch *enableCode39Switch;
@property (retain, nonatomic) IBOutlet UISwitch *enableITFSwitch;
@property (retain, nonatomic) IBOutlet UISwitch *enableCodabarSwitch;
@property (retain, nonatomic) IBOutlet UISwitch *enableStickybitsSwitch;
@property (retain, nonatomic) IBOutlet UISwitch *enableQRCodeSwitch;
@property (retain, nonatomic) IBOutlet UISwitch *enableDatamatrixSwitch;

@property (retain, nonatomic) IBOutlet UILabel *readyStatusLabel;

- (id) initWithPicker:(BarcodePickerController *) bpc;
- (IBAction) allOnButtonPressed:(id)sender;
- (IBAction) allOffButtonPressed:(id)sender;
- (IBAction) doneButtonPressed:(id)sender;

@end
