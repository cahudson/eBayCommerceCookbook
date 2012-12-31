<h1>eBay Commerce Cookbook:</h1>
<h2>Using eBay APIs: PayPal, Magento and More</h2>
<a href="http://goo.gl/cPonT" target="_blank"><img src="http://ecx.images-amazon.com/images/I/51B%2B2xm5GkL._BO2,204,203,200_PIsitb-sticker-arrow-click,TopRight,35,-76_AA300_SH20_OU01_.jpg" align="right"/></a>
<p>This is the source code repository for the <a href="http://goo.gl/cPonT" target="_blank">eBay Commerce Cookbook</a>. The repository contains all code for the 15 recipes / examples in the text so that you can download and run the examples more easily. If you find any errors or issues please let me know and I will do my best to update the examples. 
<p>Note that the examples were written over the course of the 2012 calendar year so as the various APIs employed are improved or modified the examples may need to be updated to follow any changes. Also note, as the title implies the cookbook is designed to highlight APIs from various eBay owned sites and properties. However the basic premise to each example for improving a commerce lifecycle can be applied using eBay APIs, other APIs, or your own homegrown code. In any of the cases I hope that the examples provide some benefit and spark some methods of differentiating your commerce flow. 
<p>If you have a good idea that results or just in general and want to share feel free to contact me. I always love to hear how people are creating new "mashes" and creating new paradigms in commerce! 
<p>Either way, have a blast with e, m, s, and x commerce! - <em>Chuck</em>

<h2>Introduction</h2>

<p>The book is called <a href="http://goo.gl/cPonT" target="_blank"><em>eBay Commerce Cookbook: Using eBay APIs: PayPal, Magento and More</em></a> and is published by O’Reilly Media (Electronic - December 20, 2012, Print - January 4, 2013). It is available in Paperbook, Ebook, Kindle and via Safari Books Online.

<p>You can inspect the source code and make improvements to it. If you want to contribute, please do so! Fork it, hack on it, and send back your changes! If you want to support the work further and read the full text on each example, you can do so by <a href="http://goo.gl/cPonT" target="_blank">buying a copy</a> of the book in digital or printed form.

<h2>Organization</h2>
<p>The book consists of five chapters, each consisting of three recipes / examples, following a simplified commerce life cycle. The simplified commerce life cycle is not meant to be specific ecommerce, mcommerce, or scommerce but could represent any one of these commerce life cycles (and thus the over simplification). I have tried to involve the most common formats of commerce in the examples while incorporating newer technologies and APIs. Below is a breakdown of the chapters.
<table>
  <tr>
  <th>Chapter</th><th>Stage</th><th>Topics</th>
  </tr>
  <tr>
  <td>1</td><td>Product Discovery</td><td>provides examples covering the mapping of product availability to location using Milo, listing your products on eBay, and incorporating product reviews from eBay into your site.</td>
  </tr>
  <tr>
  <td>2</td><td>Product Presentation</td><td>provides examples including customizing the Magento storefront, personalizing
a store experience with PayPal Access, and presenting similar items from
eBay.</td>
  </tr>
  <tr>
  <td>3</td><td>Purchase</td><td>provides examples including autogenerating coupons with Magento,
payment preapproval, and donating on checkout with PayPal Adaptive Payments.</td>
  </tr>
  <tr>
  <td>4</td><td>Order Fulfillment</td><td>provides examples covering shipping form creation with PayPal Instant
Payment Notifications, shipping method extensions with Magento, and multiple
supplier payment with PayPal chained payments.</td>
  </tr>
  <tr>
  <td>5</td><td>Consumption and Sharing</td><td>includes examples on facilitating social recommendations with QR
codes, generating taste graphs and recommendations via Hunch, and social sharing
using mashups through ql.io.</td>
  </tr>
</table>
<p>The chapters are based on the stages in a simplified commerce lifecycle as shown in the image below.<br/>
<img src="https://raw.github.com/cahudson/eBayCommerceCookbook/master/preface.png"/>

<h2>Code Examples - Recipes</h2>
<p>In the book each example is documented fully with a challenge being solved, potential solution, and steps to setting up the example. Here I have placed a brief README file in the root of each example folder. The folders here follow the example numbering convention of the book, chapter number followed by example number in the chapter.
<p>In the tables below you will find a detailed list of the examples by chapter, including the primary API used and a brief description. In this way you can seek out a specific example of a certain API if needed.
<table width="100%">
  <tr>
    <td colspan="5"><span style="font-weight:bold;">Chapter 1 - Product Discovery and Research</h3></td>
  </tr>
  <th rowspan="4" width="5">&nbsp;</th><th width="15">#</th><th width="30%">Title</th><th width="20%">API/Tool</th><th>Description</th>
  <tr>
    <td>1.1</td><td><a href="https://github.com/cahudson/eBayCommerceCookbook/tree/master/1_1_tapping_into_product_reviews">Tapping into Product Reviews</a></td><td>eBay Shopping</td><td>Display product reviews from eBay users based on a specific product and the eBay Shopping API.</td>
  </tr>
  <tr>
    <td>1.2</td><td><a href="https://github.com/cahudson/eBayCommerceCookbook/tree/master/1_2_mapping_product_availability">Mapping Product Availability</a></td><td>Milo</td><td>Map onto Google Maps availability and stores for a specific product using the Milo API.</td>
  </tr>
  <tr>
    <td>1.3</td><td><a href="https://github.com/cahudson/eBayCommerceCookbook/tree/master/1_3_presenting_products_through_ebay">Presenting Products through eBay</a></td><td>eBay Trading</td><td>Display products from eBay using the eBay Trading API.</td>
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
<p>There are at least a dozen different API sets used through out the examples of the book. Each of the APIs have special licensing and terms of usage. It is of course your responsibility to determine any requirements for your project based on the licensing terms. Below is a list of the core APIs employed linked to the documentation of the APIs. Where applicable the limits and key terms have been included in the book, however the various third party API owners may change these at anytime so it is recommeneded that you verify with any provider that you may be incorporating.
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
<p>The examples provided in the book and posted here were designed to help you get your job done. In general you may use the code examples in your programs and documentation, but of course the code comes without warranty and you should take all means to "productize" the code for your specific project. You do not need to contact O'Reilly for permission unless you’re reproducing a significant portion of the code. For example, writing a program that uses several chunks of code from this book does not require permission. Selling or distributing a CD-ROM of examples from O’Reilly books does require permission. Answering a question by citing this book and quoting example code does not require permission. Incorporating a significant amount of example code from this book into your product’s documentation does require permission.
<p>We appreciate, but do not require, attribution. An attribution usually includes the title, author, publisher, and ISBN. For example: “eBay Commerce Cookbook by Charles Hudson (O’Reilly). Copyright 2013 Charles Hudson, 978-1-4493-2015-7.”
<p>If you feel your use of code examples falls outside fair use or the permission given here, feel free to contact O'Reilly Media at permissions@oreilly.com.

<h2>Contributions and Updates</h2>
<p>The world of technology is changing at a rocket pace and trying to keep up with more than a dozen different APIs can be challenging. If you find a new update or change please let me know. I will review and include in any updates if appropriate. As well it may get posted here or on the O'Reilly Media book discussion area. In either case not only will I benefit from the new information but everyone else following along. Have fun mashing together the various APIs.

<p>We encourage you to fork our work and make your own improvements under the terms of the license. If you have any changes you want to send back our way, please make a regular pull request via Github. If the authors like your changes, they may integrate them into the official book and give you a credit in the next edition. If you just have an issue to report, please use the regular Github issue system.

<h2>Book Details</h2>
<p>Title: <a href="http://goo.gl/cPonT" target="_blank">eBay Commerce Cookbook</a><br/>
Paperback: 208 pages<br/>
Publisher: O'Reilly Media (January 4, 2013)<br/>
Language: English<br/>
ISBN-10: 1449320155<br/>
ISBN-13: 978-1449320157

<p><strong>Kindle Version:</strong><br/>
Title: <a href="http://goo.gl/unbtP" target="_blank">eBay Commerce Cookbook</a><br/>
File Size: 6125 KB<br/>
Print Length: 208 pages<br/>
Simultaneous Device Usage: Unlimited<br/>
Publisher: O'Reilly Media; 1 edition (December 20, 2012)<br/>
Sold by: Amazon Digital Services, Inc.<br/>
Language: English<br/>
ASIN: B00ARN9MHC

<p><strong>Other formats:</strong><br/>
Ebook, <a href="http://my.safaribooksonline.com/9781449343859">Safari Books Online</a>

<h2>O'Reilly Animal</h2>
<img src="http://upload.wikimedia.org/wikipedia/commons/thumb/0/0b/Mississippi_Kite.jpg/220px-Mississippi_Kite.jpg" align="left"/>
<strong>Mississippi Kite</strong> (<em>Ictinia mississippiensis</em>)<br/>
<p><em>"The Mississippi Kite (Ictinia mississippiensis) is a small bird of prey in the family Accipitridae. It is 12 to 15 inches (30–37 cm) beak to tail and has a wingspan averaging 3 feet (91 cm). Weight is from 214 to 388 grams (7.6-13.7 oz).[1] Adults are gray with darker gray on their tail feathers and outer wings and lighter gray on their heads and inner wings. Males and females look alike, but the males are slightly paler on the head and neck. Young kites have banded tails and streaked bodies.[2] Mississippi Kites have narrow, pointed wings and are graceful in flight, often appearing to float in the air. It is not uncommon to see several circling in the same area. Their diet consists mostly of insects which they capture in flight. They eat cicada, grasshoppers, and other crop-damaging insects, making them economically important. They have also been known to eat small vertebrates, including amphibians, reptiles, mammals, and occasionally birds. Their call is a high-pitched squeak, sounding similar to that of a squeaky dog toy."</em> - Wikipedia.org</p>
<p><a href="http://en.wikipedia.org/wiki/Mississippi_Kite">Wikipedia.org - Mississippi Kite</a><br/>
<a href="http://www.allaboutbirds.org/guide/Mississippi_Kite/id">AllAboutBirds.org - Mississippi Kite</a><br/>
