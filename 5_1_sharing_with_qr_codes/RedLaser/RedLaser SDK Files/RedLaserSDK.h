/*******************************************************************************
	RedLaserSDK.h
	
	(c) 2009-2011 eBay Inc.
	
	This is the public API for the RedLaser SDK.
*/
#ifdef __cplusplus
extern "C" {
#endif

// Barcode Symbologies
#define kBarcodeTypeEAN13 			0x1
#define kBarcodeTypeUPCE 			0x2
#define kBarcodeTypeEAN8 			0x4
#define kBarcodeTypeSTICKY 			0x8
#define kBarcodeTypeQRCODE 			0x10
#define kBarcodeTypeCODE128 		0x20
#define kBarcodeTypeCODE39 			0x40
#define kBarcodeTypeDATAMATRIX 		0x80
#define kBarcodeTypeITF 			0x100
#define kBarcodeTypeEAN5 			0x200
#define kBarcodeTypeEAN2			0x400
#define kBarcodeTypeCodabar			0x800

typedef enum
{
	RLState_EvalModeReady = 1,
	RLState_LicensedModeReady = 2,
	
	RLState_MissingOSLibraries = -1,
	RLState_NoCamera = -2,
	RLState_BadLicense = -3,
	RLState_ScanLimitReached = -4,
} RedLaserStatus;

#if TARGET_OS_MAC

/*******************************************************************************
	RL_GetRedLaserSDKVersion()
	
	This function returns the version of the RedLaser SDK, as a NSString.
	The primary purpose of this function is checking which SDK version you're 
	linking against, to compare that version against the most recent version 
	on redlaser.com. 
*/
NSString *RL_GetRedLaserSDKVersion();

/*******************************************************************************
	RL_CheckReadyStatus()
	
	This function returns information about whether the SDK can be used. It 
	doesn't give dynamic state information about what the SDK is currently doing.
	
	Generally, positive values mean you can scan, negative values mean you 
	can't. The returned value *can* change from one call to the next. 
	
	If this function returns a negative value, it's usually best to design your
	app so that it won't attempt to scan at all. If this function returns
	MissingOSLibraries this is especially important, as the SDK will probably 
	crash if used. See the documentation. 
*/
RedLaserStatus RL_CheckReadyStatus();


#import <Foundation/Foundation.h>

@class BarcodePickerController;

/*******************************************************************************
	BarcodeResult
	
	The return type of the recognizer is a NSSet of Barcode objects.	
*/
@interface BarcodeResult : NSObject <NSCoding> { }

@property (readonly) int 					barcodeType;
@property (readonly, retain) NSString 		*barcodeString;
@property (readonly, copy) NSString 		*extendedBarcodeString;
@property (readonly) BarcodeResult 			*associatedBarcode;

@property (readonly, retain) NSDate 		*firstScanTime;
@property (readonly, retain) NSDate 		*mostRecentScanTime;
@property (readonly, retain) NSMutableArray	*barcodeLocation;
@end

/*******************************************************************************
	BarcodePickerControllerDelegate
	
	The delegate receives messages about the results of a scan. This method
	gets called when a scan session completes.	
*/
@protocol BarcodePickerControllerDelegate <NSObject>
@optional
- (void) barcodePickerController:(BarcodePickerController*)picker 
		returnResults:(NSSet *)results;
@end

#if TARGET_OS_IPHONE

/*******************************************************************************
	FindBarcodesInUIImage
	
	Searches the given image for barcodes, and returns information on all barcodes
	that it finds. This performs an exhaustive search, which can take several 
	seconds to perform. This method searches for all barcode types. The intent
	of this method is to allow for barcode searching in photos from the photo library.
*/
NSSet *FindBarcodesInUIImage(UIImage *inputImage);


/*******************************************************************************
	CameraOverlayViewController
	
	An optional overlay view that is placed on top of the camera view.
	This view controller receives status updates about the scanning state, and
	can update the user interface.	
*/
@interface CameraOverlayViewController : UIViewController { }

@property (readonly, assign) BarcodePickerController *parentPicker;

- (void)barcodePickerController:(BarcodePickerController*)picker 
		statusUpdated:(NSDictionary*)status;
@end


/*******************************************************************************
	BarcodePickerController
	
	This ViewController subclass runs the RedLaser scanner, detects barcodes, and
	notifies its delegate of what it found.
*/
@interface BarcodePickerController : UIViewController { }

- (void) pauseScanning;
- (void) resumeScanning;
- (void) prepareToScan;
- (void) clearResultsSet;
- (void) doneScanning;
- (BOOL) hasFlash;
- (void) turnFlash:(BOOL)value;
- (void) requestCameraSnapshot;

@property (nonatomic, retain) CameraOverlayViewController *overlay;
@property (nonatomic, assign) id <BarcodePickerControllerDelegate> delegate;
@property (nonatomic, assign) BOOL scanUPCE;
@property (nonatomic, assign) BOOL scanEAN8;
@property (nonatomic, assign) BOOL scanEAN13;
@property (nonatomic, assign) BOOL scanSTICKY;
@property (nonatomic, assign) BOOL scanQRCODE;
@property (nonatomic, assign) BOOL scanCODE128;
@property (nonatomic, assign) BOOL scanCODE39;
@property (nonatomic, assign) BOOL scanDATAMATRIX;
@property (nonatomic, assign) BOOL scanITF;
@property (nonatomic, assign) BOOL scanEAN5;
@property (nonatomic, assign) BOOL scanEAN2;
@property (nonatomic, assign) BOOL scanCODABAR;
@property (nonatomic, assign) CGRect activeRegion;
@property (nonatomic, assign) UIImageOrientation orientation;
@property (nonatomic, assign) BOOL torchState;
@property (readonly, assign)  BOOL isFocusing;
@property (nonatomic, assign) BOOL useFrontCamera;

@end

#endif
#endif

#ifdef __cplusplus
}
#endif

