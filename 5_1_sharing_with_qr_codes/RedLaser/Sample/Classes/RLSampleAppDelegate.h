/*******************************************************************************
	RLSampleAppDelegate.h
	
	App delegate. Nothing interesting here in terms of how the sample app works.
	
	Chall Fry
	February 2012
	Copyright (c) 2012 eBay Inc. All rights reserved.	
*/
#pragma once

#import <UIKit/UIKit.h>

@class RLSampleViewController;

@interface RLSampleAppDelegate : NSObject <UIApplicationDelegate> 
{
    UIWindow *window;
    RLSampleViewController *viewController;
}

@property (nonatomic, retain) IBOutlet UIWindow *window;
@property (nonatomic, retain) IBOutlet RLSampleViewController *viewController;

@end

