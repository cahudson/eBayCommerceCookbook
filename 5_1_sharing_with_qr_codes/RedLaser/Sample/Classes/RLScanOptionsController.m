/*******************************************************************************
	RLScanOptionsController.m
	
	Switches to enable individual barcode symbologies.
	
	Chall Fry
	February 2012
	Copyright (c) 2012 eBay Inc. All rights reserved.	
*/

#import "RedLaserSDK.h"
#import "RLScanOptionsController.h"

@interface RLScanOptionsController ()
- (void) setSwitchStatesWithScheme:(int) scheme;
- (void) setEnabledCodeTypesFromSwitchStates;

@end

@implementation RLScanOptionsController

@synthesize optionScrollerView;
@synthesize optionContainerView;

@synthesize enableEAN13Switch;
@synthesize enableEAN8Switch;
@synthesize enableUPCESwitch;
@synthesize enableEAN5Switch;
@synthesize enableEAN2Switch;
@synthesize enableCode128Switch;
@synthesize enableCode39Switch;
@synthesize enableITFSwitch;
@synthesize enableCodabarSwitch;
@synthesize enableStickybitsSwitch;
@synthesize enableQRCodeSwitch;
@synthesize enableDatamatrixSwitch;
@synthesize readyStatusLabel;

- (id) initWithPicker:(BarcodePickerController *) bpc
{
    self = [super initWithNibName:nil bundle:nil];
    if (self) 
	{
		picker = bpc;
		[self setSwitchStatesWithScheme:0];
    }
    return self;
}

- (void)dealloc 
{
	[enableEAN13Switch release];
	[enableEAN8Switch release];
	[enableUPCESwitch release];
	[enableEAN5Switch release];
	[enableEAN2Switch release];
	[enableCode128Switch release];
	[enableCode39Switch release];
	[enableITFSwitch release];
	[enableCodabarSwitch release];
	[enableStickybitsSwitch release];
	[enableQRCodeSwitch release];
	[enableDatamatrixSwitch release];
    [readyStatusLabel release];
	[optionContainerView release];

	[super dealloc];
}

- (void)didReceiveMemoryWarning
{
    // Releases the view if it doesn't have a superview.
    [super didReceiveMemoryWarning];
    
    // Release any cached data, images, etc that aren't in use.
}

#pragma mark - View lifecycle

- (void)viewDidLoad
{
    [super viewDidLoad];

	// Put the option container view inside the scrollview, 
	// and size the scrollview appropriately.
	CGRect contentFrame = optionContainerView.frame;
	[optionScrollerView addSubview:optionContainerView];
	[optionScrollerView setContentSize:contentFrame.size];
}

- (void)viewDidUnload
{
	[self setEnableEAN13Switch:nil];
	[self setEnableEAN8Switch:nil];
	[self setEnableUPCESwitch:nil];
	[self setEnableEAN5Switch:nil];
	[self setEnableEAN2Switch:nil];
	[self setEnableCode128Switch:nil];
	[self setEnableCode39Switch:nil];
	[self setEnableITFSwitch:nil];
	[self setEnableCodabarSwitch:nil];
	[self setEnableStickybitsSwitch:nil];
	[self setEnableQRCodeSwitch:nil];
	[self setEnableDatamatrixSwitch:nil];
    [self setReadyStatusLabel:nil];
	
	[self setOptionContainerView:nil];

    [super viewDidUnload];
}

- (void) viewWillAppear:(BOOL)animated
{
	[super viewWillAppear:animated];
	
	RedLaserStatus sdkStatus = RL_CheckReadyStatus();
	NSString *sdkStatusString = nil;
	switch (sdkStatus)
	{
		case RLState_EvalModeReady: sdkStatusString = @"Eval Mode Ready"; break;
		case RLState_LicensedModeReady: sdkStatusString = @"Licensed Mode Ready"; break;
		case RLState_MissingOSLibraries: sdkStatusString = @"Missing OS Libs"; break;
		case RLState_NoCamera: sdkStatusString = @"No Camera"; break;
		case RLState_BadLicense: sdkStatusString = @"Bad License"; break;
		case RLState_ScanLimitReached: sdkStatusString = @"Scan Limit Reached"; break;
		default: sdkStatusString = @"Unknown"; break;
	}
	[readyStatusLabel setText:[NSString stringWithFormat:@"SDK Ready Status: %@", sdkStatusString]];
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    // Return YES for supported orientations
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}

- (IBAction) allOnButtonPressed:(id)sender 
{
	[self setSwitchStatesWithScheme:1];
}

- (IBAction) allOffButtonPressed:(id)sender 
{
 	[self setSwitchStatesWithScheme:2];
}

- (IBAction)doneButtonPressed:(id)sender 
{
	// Make the picker match the states of the switches, and close the panel.
	// Note that we could instead make each switch's action method be
	// setEnabledCodeTypesFromSwitches.
	[self setEnabledCodeTypesFromSwitchStates];
	[self dismissModalViewControllerAnimated:TRUE];
}

- (void) setSwitchStatesWithScheme:(int) scheme
{
	// Scheme 0 sets the switches to match the barcode picker controller.
	// 1 turns all switches on. 2 turns them all off.
	bool allOn = scheme == 1;
	bool allOff = scheme == 2;
	
	[self.enableEAN13Switch setOn:(picker.scanEAN13 || allOn) && !allOff animated:YES];
	[self.enableEAN8Switch setOn:(picker.scanEAN8 || allOn) && !allOff animated:YES];
	[self.enableUPCESwitch setOn:(picker.scanUPCE || allOn) && !allOff animated:YES];
	[self.enableEAN5Switch setOn:(picker.scanEAN5 || allOn) && !allOff animated:YES];
	[self.enableEAN2Switch setOn:(picker.scanEAN2 || allOn) && !allOff animated:YES];
	[self.enableCode128Switch setOn:(picker.scanCODE128 || allOn) && !allOff animated:YES];
	[self.enableCode39Switch setOn:(picker.scanCODE39 || allOn) && !allOff animated:YES];
	[self.enableITFSwitch setOn:(picker.scanITF || allOn) && !allOff animated:YES];
	[self.enableCodabarSwitch setOn:(picker.scanCODABAR || allOn) && !allOff animated:YES];
	[self.enableStickybitsSwitch setOn:(picker.scanSTICKY || allOn) && !allOff animated:YES];
	[self.enableQRCodeSwitch setOn:(picker.scanQRCODE || allOn) && !allOff animated:YES];
	[self.enableDatamatrixSwitch setOn:(picker.scanDATAMATRIX || allOn) && !allOff animated:YES];
}

- (void) setEnabledCodeTypesFromSwitchStates
{
	picker.scanEAN13 = self.enableEAN13Switch.isOn;
	picker.scanEAN8 = self.enableEAN8Switch.isOn;
	picker.scanUPCE = self.enableUPCESwitch.isOn;
	picker.scanEAN5 = self.enableEAN5Switch.isOn;
	picker.scanEAN2 = self.enableEAN2Switch.isOn;
	picker.scanCODE128 = self.enableCode128Switch.isOn;
	picker.scanCODE39 = self.enableCode39Switch.isOn;
	picker.scanITF = self.enableITFSwitch.isOn;
	picker.scanCODABAR = self.enableCodabarSwitch.isOn;
	picker.scanSTICKY = self.enableStickybitsSwitch.isOn;
	picker.scanQRCODE = self.enableQRCodeSwitch.isOn;
	picker.scanDATAMATRIX = self.enableDatamatrixSwitch.isOn;
}

@end
