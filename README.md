<h1>eBay Commerce Cookbook:</h1>
<h2>Using eBay APIs: PayPal, Magento and More</h2>

<p>This is the source code repository for a book about improving the commerce lifecycle by leveraging APIs from the various eBay owned properties.

<h2>Introduction</h2>

<p>The book is called <em>eBay Commerce Cookbook: Using eBay APIs: PayPal, Magento and More</em> and is published by O’Reilly Media.

<p>You can inspect the source code and make improvements to it, and similarly you can inspect the source code for this book and make improvements to it. If you want to contribute, please do so! Fork it, hack on it, and send back your changes! If you want to support the project, you can do so by <a href="http://shop.oreilly.com/product/0636920023968.do" target="_blank" >buying a copy</a> of the book in digital or printed form.
<p>Implementing solutions around commerce incorporated various APIs including several from eBay owned properties. Examples include APIs from :
ql.io, redlaser, ebay, paypal, magento

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

<h2>Code Examples - Recipes</h2>
<p>README at the top of each directory

<table width="100%">
  <tr>
    <td colspan="5"><span style="font-weight:bold;">Chapter 1 - Product Discovery and Research</h3></td>
  </tr>
  <th rowspan="4" width="5">&nbsp;</th><th width="15">#</th><th width="30%">Title</th><th width="20%">API/Tool</th><th>Description</th>
  <tr>
    <td>1.1</td><td>Tapping into Product Reviews</td><td>eBay Shopping</td><td>Display product reviews from eBay users based on a specific product and the eBay Shopping API.</td>
  </tr>
  <tr>
    <td>1.2</td><td>Mapping Product Availability</td><td>Milo</td><td>Map onto Google Maps availability and stores for a specific product using the Milo API.</td>
  </tr>
  <tr>
    <td>1.3</td><td>Presenting Products through eBay</td><td>eBay Trading</td><td>Display products from eBay using the eBay Trading API.</td>
  </tr>
</table>

<table width="100%">
  <tr>
    <td colspan="5"><span style="font-weight:bold;">Chapter 2 - Product Presentation</h3></td>
  </tr>
  <th rowspan="4" width="5">&nbsp;</th><th width="15">#</th><th width="30%">Title</th><th width="20%">API/Tool</th><th>Description</th>
  <tr>
    <td>2.1</td><td>Customizing a Magento Storefront</td><td>Magento</td><td>Add in Facebook like / use integration in your Magento storefront with a Facebook App, X.Commerce messaging and Magento community edition.</td>
  </tr>
  <tr>
    <td>2.2</td><td>Personalizing a Store Experience</td><td>PayPal Access</td><td>Providing an alternate sign in with a trusted third party, PayPal, incorporating the PayPal Access / Identity offering.</td>
  </tr>
  <tr>
    <td>2.3</td><td>Presenting Similar Items</td><td>eBay Merchandising</td><td>Present similar items to a specific item from eBay using the eBay Merchandising API.</td>
  </tr>
</table>

<table width="100%">
  <tr>
    <td colspan="5"><span style="font-weight:bold;">Chapter 3 - Enhancing the Payment Experience</h3></td>
  </tr>
  <th rowspan="4" width="5">&nbsp;</th><th width="15">#</th><th width="30%">Title</th><th width="20%">API/Tool</th><th>Description</th>
  <tr>
    <td>3.1</td><td>Autogenerating Coupons</td><td>Magento</td><td>Wrap the new Magento autogeneration of coupons to create a REST API for creating coupons dynamically.</td>
  </tr>
  <tr>
    <td>3.2</td><td>Preapproval Payments</td><td>PayPal Adaptive</td><td>Using PayPal Adaptive Payments to provide preapproved payment solutions where customers can preapprove future payments.</td>
  </tr>
  <tr>
    <td>3.3</td><td>Giving Back at Checkout</td><td>PayPal Adaptive</td><td>Provide a way to give to charities directly in a single sales transaction using the PayPal Adaptive Payments parallel payment model.</td>
  </tr>
</table>

<table width="100%">
  <tr>
    <td colspan="5"><span style="font-weight:bold;">Chapter 4 - Order Fulfillment</h3></td>
  </tr>
  <th rowspan="4" width="5">&nbsp;</th><th width="15">#</th><th width="30%">Title</th><th width="20%">API/Tool</th><th>Description</th>
  <tr>
    <td>4.1</td><td>Just-in-Time Shipping Forms</td><td>PayPal IPN</td><td>Create in real time, shipping forms from PayPal Instant Payment Notifications for goods purchased.</td>
  </tr>
  <tr>
    <td>4.2</td><td>Simple Shipping Extension</td><td>Magento</td><td>Add your own shipping extension with personalized shipping methods and cost formulas into Magento.</td>
  </tr>
  <tr>
    <td>4.3</td><td>Multiple Supplier Fulfillment</td><td>PayPal Adaptive</td><td>Leverage the PayPal Adaptive Payments offering to create a chained payment model for paying multiple vendors in a single transaction.</td>
  </tr>
</table>

<table width="100%">
  <tr>
    <td colspan="5"><span style="font-weight:bold;">Chapter 5 - Consumption and Sharing</h3></td>
  </tr>
  <th rowspan="4" width="5">&nbsp;</th><th width="15">#</th><th width="30%">Title</th><th width="20%">API/Tool</th><th>Description</th>
  <tr>
    <td>5.1</td><td>Sharing with QR Codes</td><td>RedLaser</td><td>Dynamically create QR codes for products with the Google API and then leverage the RedLaser API in an iPhone app to scan the code and launch a Scan It, Share It page.</td>
  </tr>
  <tr>
    <td>5.2</td><td>Creating a Taste Graph</td><td>Hunch</td><td>Use the Hunch API to create a personalized taste graph based on a purchase of a product and a customer's twitter username.</td>
  </tr>
  <tr>
    <td>5.3</td><td>Social Recommendations</td><td>ql.io</td><td>Use ql.io to aggregate three separate API calls to create personalized social recommendations from Hunch and eBay.</td>
  </tr>
</table>

<h2>API Usage</h2>
<p>There are at least a dozen different API sets used through out the examples of the book. Each of the APIs have special licensing and terms of usage. Below is a list of the core APIs employed linked to the documentation of the APIs. Where applicable the limits and key terms have been included in the book, however the various third party API owners may change these at anytime so it is recommeneded that you verify with any provider that you may be incorporating.
<p>
<code><a href="http://developer.ebay.com/DevZone/merchandising/docs/Concepts/MerchandisingAPIGuide.html" target="_blank">eBay Merchandising API</a></code>
<code><a href="http://developer.ebay.com/DevZone/shopping/docs/Concepts/ShoppingAPIGuide.html" target="_blank">eBay Shopping API</a></code>
<code><a href="http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/" target="_blank">eBay Trading API</a></code>
<code><a href="https://developers.google.com/chart/infographics/docs/qr_codes" target="_blank">Google Infographics QR Codes</a></code>
<code><a href="http://hunch.com/developers/v1/" target="_blank">Hunch</code></a></dt>
<code><a href="http://www.magentocommerce.com/api/rest/introduction.html" target="_blank">Magento</a></code>
<code><a href="https://www.x.com/developers/documentation-tools/milo/miloindex" target="_blank">Milo</a></code>
<code><a href="https://www.x.com/developers/paypal/products/paypal-access" target="_blank">PayPal Access</a></code>
<code><a href="https://www.x.com/developers/paypal/documentation-tools/adaptive-payments/integration-guide/APIntro" target="_blank">PayPal Adaptive Payments</a></code>
<code><a href="https://www.x.com/developers/paypal/documentation-tools/ipn/integration-guide/IPNIntro" target="_blank">PayPal Instant Payment Notification (IPN)</a></code>
<code><a href="http://ql.io/docs" target="_blank">ql.io</a></code>
<code><a href="http://redlaser.com/developers/" target="_blank">RedLaser</a></code>

<h2>Using Code Examples</h2>
<p>This book is here to help you get your job done. In general, if this book includes code examples, you may use the code in your programs and documentation. You do not need to contact us for permission unless you’re reproducing a significant portion of the code. For example, writing a program that uses several chunks of code from this book does not require permission. Selling or distributing a CD-ROM of examples from O’Reilly books does require permission. Answering a question by citing this book and quoting example code does not require permission. Incorporating a significant amount of example code from this book into your product’s documentation does require permission.
<p>We appreciate, but do not require, attribution. An attribution usually includes the title, author, publisher, and ISBN. For example: “eBay Commerce Cookbook by Charles Hudson (O’Reilly). Copyright 2013 Charles Hudson, 978-1-4493-2015-7.”
<p>If you feel your use of code examples falls outside fair use or the permission given here, feel free to contact us at permissions@oreilly.com.

<h2>Contributions and Updates</h2>
<p>The world of technology is changing at a rocket pace and trying to keep up with more than a dozen different APIs can be challenging. If you find a new update or change please let me know. I will review and include in any updates if appropriate. As well it may get posted here or on the O'Reilly Media book discussion area. In either case not only will I benefit from the new information but everyone else following along. Have fun mashing together the various APIs.
<p>The book is made available

<p>We encourage you to fork our work and make your own improvements under the terms of the license. If you have any changes you want to send back our way, please make a regular pull request via Github. If the authors like your changes, they may integrate them into the official book and give you a credit in the next edition. If you just have an issue to report, please use the regular Github issue system.
