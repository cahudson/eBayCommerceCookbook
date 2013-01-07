/*******************************************************************************
	RLSampleViewController.m
	
	This is the view controller for the results table.
	
	Chall Fry
	February 2012
	Copyright (c) 2012 eBay Inc. All rights reserved.	
*/

#import "RLSampleViewController.h"
#import "OverlayController.h"
#import "MultiScanOverlayController.h"
#import "RedLaserSDK.h"

@interface RLSampleViewController ()
- (void) appBecameActive:(NSNotification *) notification;

@end


@implementation RLSampleViewController

- (id) initWithCoder:(NSCoder *)decoder
{
	if (self = [super initWithCoder:decoder])
	{	
		// Load in any saved scan history we may have
		@try {
    		NSString *documentsDir = [NSSearchPathForDirectoriesInDomains(NSDocumentDirectory,
				NSUserDomainMask, YES) objectAtIndex:0];
			NSString *archivePath = [documentsDir stringByAppendingPathComponent:@"ScanHistoryArchive"];
			scanHistory = [[NSKeyedUnarchiver unarchiveObjectWithFile:archivePath] retain];
		}
		@catch (...) 
		{
    	}
		if (!scanHistory)
			scanHistory = [[NSMutableArray alloc] init];

		// We create the BarcodePickerController here so that we can call prepareToScan before
		// the user actually requests a scan. 
		pickerController = [[BarcodePickerController alloc] init];
		[pickerController setDelegate:self];

		[[NSNotificationCenter defaultCenter] addObserver:self selector:@selector(appBecameActive:) 
				name:UIApplicationDidBecomeActiveNotification object:nil];
	}
	
	return self;
}

- (void) dealloc 
{
	[[NSNotificationCenter defaultCenter] removeObserver:self];

	[scanHistory release];

	[optionsController release];
	[pickerController release];
	
	[scanHistoryTable release];
	[firstTimeView release];

	[appNameAndVersionLabel release];
	[super dealloc];
}

- (void) viewDidLoad
{
	// Put the SDK version in the titlebar
	appNameAndVersionLabel.text = [NSString stringWithFormat:@"RLSample %@", 
			RL_GetRedLaserSDKVersion()];

	[pickerController prepareToScan];
	[firstTimeView setHidden:[scanHistory count] != 0];
}

- (void) viewDidUnload 
{
	[scanHistoryTable release];
	scanHistoryTable = nil;
	[firstTimeView release];
	firstTimeView = nil;
	[appNameAndVersionLabel release];
	appNameAndVersionLabel = nil;
	[super viewDidUnload];
}


// When the app launches or is foregrounded, this will get called via NSNotification
// to warm up the camera.
- (void) appBecameActive:(NSNotification *) notification
{
	[pickerController prepareToScan];
}

// This is the delegate method of the BarcodePickerController. When a scan is completed, this
// method will be called with a (possibly null) set of BarcodeResult objects.
- (void) barcodePickerController:(BarcodePickerController*)picker returnResults:(NSSet *)results
{	
	[[UIApplication sharedApplication] setStatusBarHidden:NO];
	
	// Restore main screen (and restore title bar for 3.0)
	[self dismissModalViewControllerAnimated:TRUE];
	
	// If there's any results, save them in our scan history
	if (results && [results count])
	{
		NSMutableDictionary *scanSession = [[NSMutableDictionary alloc] init];
		[scanSession setObject:[NSDate date] forKey:@"Session End Time"];
		[scanSession setObject:[results allObjects] forKey:@"Scanned Items"];
		[scanHistory insertObject:scanSession atIndex:0];
		
		// Save our new scans out to the archive file
		NSString *documentsDir = [NSSearchPathForDirectoriesInDomains(NSDocumentDirectory,
				NSUserDomainMask, YES) objectAtIndex:0];
		NSString *archivePath = [documentsDir stringByAppendingPathComponent:@"ScanHistoryArchive"];
		[NSKeyedArchiver archiveRootObject:scanHistory toFile:archivePath];
		
		[scanHistoryTable reloadData];
		[firstTimeView setHidden:TRUE];
	}
}

- (IBAction) optionsButtonPressed:(id)sender 
{
	if (!optionsController)
	{
		optionsController = [[RLScanOptionsController alloc] initWithPicker:pickerController];
	}
	
	[self presentModalViewController:optionsController animated:TRUE];
}

// This button initiates a scan session to scan a single barcode. The session will exit
// as soon as something is found.
- (IBAction) scanButtonPressed
{
	// Make ourselves an overlay controller and tell the SDK about it.	
	OverlayController *overlayController = [[OverlayController alloc] init];
	[pickerController setOverlay:overlayController];
	[overlayController release];
	
	// hide the status bar and show the scanner view
	[[UIApplication sharedApplication] setStatusBarHidden:YES];
	[self presentModalViewController:pickerController animated:FALSE];
}

// This button initiates a multi barcode scan session. The session will keep running until
// the user clicks the 'done' button in the overlay. Note that this session also uses a
// different style overlay.
- (IBAction) multiScanButtonPressed
{
	// Make ourselves an overlay controller and tell the SDK about it.
	// Why 2 different overlays? Only for demonstrating different things that can be done.
	MultiScanOverlayController *overlayController = [[MultiScanOverlayController alloc] init];
	[pickerController setOverlay:overlayController];
	[overlayController release];
	
	// hide the status bar and show the scanner view
	[[UIApplication sharedApplication] setStatusBarHidden:YES];
	[self presentModalViewController:pickerController animated:TRUE];
}

- (IBAction)clearButtonPressed:(id)sender 
{
	[scanHistory removeAllObjects];
	[scanHistoryTable reloadData];
	[firstTimeView setHidden:FALSE];
}

#pragma mark - UITableViewDataSource

- (NSInteger) numberOfSectionsInTableView:(UITableView *)tableView
{
	return [scanHistory count];
}

- (NSString *)tableView:(UITableView *)tableView titleForHeaderInSection:(NSInteger)section
{
	NSMutableDictionary *scanSession = [scanHistory objectAtIndex:section];
	
	NSDate *scanTime = [scanSession objectForKey:@"Session End Time"];
	
	NSDateFormatter *dateFormatter = [[[NSDateFormatter alloc] init] autorelease];
	[dateFormatter setDateStyle:NSDateFormatterMediumStyle];
	[dateFormatter setTimeStyle:NSDateFormatterMediumStyle];
	NSString *formattedDateString = [dateFormatter stringFromDate:scanTime];
	
	return formattedDateString;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
	NSMutableDictionary *scanSession = [scanHistory objectAtIndex:section];
	
	return [[scanSession objectForKey:@"Scanned Items"] count];
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
	UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:@"BarcodeResult"];
    if (cell == nil) 
	{
        cell = [[[UITableViewCell alloc] initWithStyle:UITableViewCellStyleSubtitle 
				reuseIdentifier:@"BarcodeResult"] autorelease];
        cell.selectionStyle = UITableViewCellSelectionStyleNone;
    }
	
	// Get the barcodeResult that has the data backing this cell
	NSMutableDictionary *scanSession = [scanHistory objectAtIndex:indexPath.section];
	BarcodeResult *barcode = [[scanSession objectForKey:@"Scanned Items"] objectAtIndex:indexPath.row];

    cell.textLabel.text = barcode.barcodeString;
	
	switch (barcode.barcodeType) 
	{
		case kBarcodeTypeEAN13: cell.detailTextLabel.text = @"EAN-13"; break;
		case kBarcodeTypeEAN8: cell.detailTextLabel.text = @"EAN-8"; break;
		case kBarcodeTypeUPCE: cell.detailTextLabel.text = @"UPC-E"; break;
		case kBarcodeTypeEAN5: cell.detailTextLabel.text = @"EAN-5"; break;
		case kBarcodeTypeEAN2: cell.detailTextLabel.text = @"EAN-2"; break;
		case kBarcodeTypeSTICKY: cell.detailTextLabel.text = @"Stickbits"; break;
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

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath {
    
    // Retrieve cell that has been selected based on indexPath.
    UITableViewCell *cell = [tableView cellForRowAtIndexPath:indexPath];
    
    // Create URL with the textLabel of the cell since that is what was scanned.
    NSURL *url = [NSURL URLWithString:cell.textLabel.text];
    
    // Open the URL that was scanned.
    [[UIApplication sharedApplication] openURL:url];
}



@end
