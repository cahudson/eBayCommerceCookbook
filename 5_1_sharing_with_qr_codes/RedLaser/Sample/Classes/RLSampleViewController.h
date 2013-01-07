/*******************************************************************************
	RLSampleViewController.h
	
	This is the view controller for the results table.
	
	Chall Fry
	February 2012
	Copyright (c) 2012 eBay Inc. All rights reserved.	
*/

#pragma once

#import <UIKit/UIKit.h>
#import "RedLaserSDK.h"

#import "OverlayController.h"
#import "RLScanOptionsController.h"

@interface RLSampleViewController : UIViewController 
		<BarcodePickerControllerDelegate, UITableViewDelegate, UITableViewDataSource> 
{
	NSMutableArray				*scanHistory;
	
	IBOutlet UITableView 		*scanHistoryTable;
	IBOutlet UILabel 			*appNameAndVersionLabel;
	IBOutlet UIView 			*firstTimeView;
	
	RLScanOptionsController 	*optionsController;
	BarcodePickerController		*pickerController;
	
}

- (IBAction) optionsButtonPressed:(id)sender;
- (IBAction) scanButtonPressed;
- (IBAction) multiScanButtonPressed;
- (IBAction) clearButtonPressed:(id)sender;

@end

