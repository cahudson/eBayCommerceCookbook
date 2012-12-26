<h1>eBay Commerce Cookbook:</h1>
<h2>Using eBay APIs: PayPal, Magento and More</h2>

<p>This is the source code repository for a book about improving the commerce lifecycle by leveraging APIs from the various eBay owned properties.

<h2>Introduction</h2>

<p>The book is called <em>eBay Commerce Cookbook: Using eBay APIs: PayPal, Magento and More</em> and is published by O’Reilly Media.

<p>You can inspect the source code and make improvements to it, and similarly you can inspect the source code for this book and make improvements to it. If you want to contribute, please do so! Fork it, hack on it, and send back your changes! If you want to support the project, you can do so by <a href="http://shop.oreilly.com/product/0636920023968.do" target="_blank" >buying a copy</a> of the book in digital or printed form.
<p>Implementing solutions around commerce incorporated various APIs including several from eBay owned properties. Examples include APIs from :
ql.io, redlaser, ebay, paypal, magento

<h2>Code Examples - Recipes</h2>
<p>README at the top of each directory

<h2>Organization</h2>
<p>The book consists of five chapters following the simplified commerce life cycle:
<table>
  <tr>
    <th>Chapter</th><th>Stage</th><th>Topics</th>
  </tr>
  <tr>
    <td>1</td><td></td><td>provides examples covering the mapping of product availability to location
using Milo, listing your products on eBay, and incorporating product reviews
from eBay into your site.</td>
  </tr>
  <tr>
    <td>2</td><td></td><td>provides examples including customizing the Magento storefront, personalizing
a store experience with PayPal Access, and presenting similar items from
eBay.</td>
  </tr>
  <tr>
    <td>3</td><td></td><td>provides examples including autogenerating coupons with Magento,
payment preapproval, and donating on checkout with PayPal Adaptive Payments.</td>
  </tr>
  <tr>
    <td>4</td><td></td><td>provides examples covering shipping form creation with PayPal Instant
Payment Notifications, shipping method extensions with Magento, and multiple
supplier payment with PayPal chained payments.</td>
  </tr>
  <tr>
    <td>5</td><td></td><td>includes examples on facilitating social recommendations with QR
codes, generating taste graphs and recommendations via Hunch, and social sharing
using mashups through ql.io.</td>
  </tr>
</table>
<p>The chapters are based on the stages in a simplified commerce lifecycle as shown in the image below.
<p>![Simplified Commerce Lifecycle](https://raw.github.com/cahudson/eBayCommerceCookbook/master/preface.png)
3 in each section

<h2>API Usage</h2>
11 different APIs
<p>
<code>eBay Merchandising API</code>
<code>eBay Shopping API</code>
<code>eBay Trading API</code>
<code>Hunch</code></dt>
<code>Magento</code>
<code>Milo</code>
<code>PayPal Access</code>
<code>PayPal Adaptive Payments</code>
<code>PayPal Instant Payment Notification (IPN)</code>
<code>ql.io</code>
<code>RedLaser</code>

<table width="100%">
  <tr>
    <td colspan="5"><span style="font-weight:bold;">Chapter 1 - Product Discovery and Research</h3></td>
  </tr>
  <th rowspan="4" width="5">&nbsp;</th><th width="15">#</th><th width="30%">Title</th><th width="20%">API</th><th>Description</th>
  <tr>
    <td>1.1</td><td>Tapping into Product Reviews and Guides</td><td>eBay Shopping API</td><td></td>
  </tr>
  <tr>
    <td>1.2</td><td>Mapping Product Availability</td><td>Milo API</td><td></td>
  </tr>
  <tr>
    <td>1.3</td><td>Presenting Products through eBay</td><td>eBay Trading API</td><td></td>
  </tr>
</table>

<table>
  <tr>
    <td colspan="5"><span style="font-weight:bold;">Chapter 2 - Product Presentation</h3></td>
  </tr>
  <th rowspan="4" width="5">&nbsp;</th><th width="15">#</th><th width="30%">Title</th><th width="20%">API</th><th>Description</th>
  <tr>
    <td>2.1</td><td>Customizing a Magento Storefront</td><td>Magento</td><td></td>
  </tr>
  <tr>
    <td>2.2</td><td>Personalizing a Store Experience</td><td>PayPal Access</td><td></td>
  </tr>
  <tr>
    <td>2.3</td><td>Presenting Similar Items</td><td>eBay Merchandising API</td><td></td>
  </tr>
</table>

<table>
  <tr>
    <td colspan="5"><span style="font-weight:bold;">Chapter 3 - Enhancing the Payment Experience</h3></td>
  </tr>
  <th rowspan="4" width="5">&nbsp;</th><th width="15">#</th><th width="30%">Title</th><th width="20%">API</th><th>Description</th>
  <tr>
    <td>3.1</td><td>Autogenerating Coupons with Magento</td><td>Magento</td><td></td>
  </tr>
  <tr>
    <td>3.2</td><td>Making Payments with Preapprovements</td><td>PayPal Adaptive Payments</td><td></td>
  </tr>
  <tr>
    <td>3.3</td><td>Giving Back at Checkout</td><td>PayPal Adaptive Payments</td><td></td>
  </tr>
</table>

<table>
  <tr>
    <td colspan="5"><span style="font-weight:bold;">Chapter 4 - Order Fulfillment</h3></td>
  </tr>
  <th rowspan="4" width="5">&nbsp;</th><th width="15">#</th><th width="30%">Title</th><th width="20%">API</th><th>Description</th>
  <tr>
    <td>4.1</td><td>Just-in-Time Shipping Forms</td><td>PayPal Instant Payment Notification (IPN)</td><td></td>
  </tr>
  <tr>
    <td>4.2</td><td>Simple Shipping Extension in Magento</td><td>Magento</td><td></td>
  </tr>
  <tr>
    <td>4.3</td><td>Multiple Supplier Fulfillment</td><td>PayPal Adaptive Payments</td><td></td>
  </tr>
</table>

<table>
  <tr>
    <td colspan="5"><span style="font-weight:bold;">Chapter 5 - Consumption and Sharing</h3></td>
  </tr>
  <th rowspan="4" width="5">&nbsp;</th><th width="15">#</th><th width="30%">Title</th><th width="20%">API</th><th>Description</th>
  <tr>
    <td>5.1</td><td>Sharing with QR Codes</td><td>RedLaser</td><td></td>
  </tr>
  <tr>
    <td>5.2</td><td>Creating a Taste Graph</td><td>Hunch</td><td></td>
  </tr>
  <tr>
    <td>5.3</td><td>Social Recommendations</td><td>ql.io</td><td></td>
  </tr>
</table>

<h2>Using Code Examples</h2>
<p>This book is here to help you get your job done. In general, if this book includes code examples, you may use the code in your programs and documentation. You do not need to contact us for permission unless you’re reproducing a significant portion of the code. For example, writing a program that uses several chunks of code from this book does not require permission. Selling or distributing a CD-ROM of examples from O’Reilly books does require permission. Answering a question by citing this book and quoting example code does not require permission. Incorporating a significant amount of example code from this book into your product’s documentation does require permission.
<p>We appreciate, but do not require, attribution. An attribution usually includes the title, author, publisher, and ISBN. For example: “eBay Commerce Cookbook by Charles Hudson (O’Reilly). Copyright 2013 Charles Hudson, 978-1-4493-2015-7.”
<p>If you feel your use of code examples falls outside fair use or the permission given here, feel free to contact us at permissions@oreilly.com.

<h2>Contributions</h2>

<p>The book is made available

<p>We encourage you to fork our work and make your own improvements under the terms of the license. If you have any changes you want to send back our way, please make a regular pull request via Github. If the authors like your changes, they may integrate them into the official book and give you a credit in the next edition. If you just have an issue to report, please use the regular Github issue system.
