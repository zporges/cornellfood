//
//  GTViewController.m
//  Cornell Food
//
//  Created by Zach Porges on 11/3/13.
//  Copyright (c) 2013 Zach Porges. All rights reserved.
//

#import "GTViewController.h"

@interface GTViewController ()

@end

@implementation GTViewController
@synthesize webview;

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.
    NSURL *url = [NSURL URLWithString:@"http://www.zachporges.com/cornellfood"];
    NSURLRequest *myrequest = [NSURLRequest requestWithURL:url];
    [webview loadRequest:myrequest];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
