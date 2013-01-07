/*******************************************************************************
	RLSampleAppDelegate.m
	
	App delegate. Nothing interesting here in terms of how the sample app works.
	
	Chall Fry
	February 2012
	Copyright (c) 2012 eBay Inc. All rights reserved.	
*/

#import "RLSampleAppDelegate.h"
#import "RLSampleViewController.h"

@implementation RLSampleAppDelegate

@synthesize window;
@synthesize viewController;


- (void)applicationDidFinishLaunching:(UIApplication *)application 
{    
	[[UIApplication sharedApplication] setStatusBarStyle:UIStatusBarStyleBlackOpaque];
	
    // Override point for customization after app launch    
    [window addSubview:viewController.view];
    [window makeKeyAndVisible];
}

- (void)dealloc 
{
    [viewController release];
    [window release];
    [super dealloc];
}


@end
