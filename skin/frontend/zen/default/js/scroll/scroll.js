var productTemplateGrid = '<div class="category-item">' +
    '<div class="products-item products-item-#{productId}">' +
        '<div class="products-item-img">' +
            '<a href="#{productUrl}" title="#{productName}" class="product-image">' +
                '<img class="img-responsive" src="#{productSmallImageUrl}" alt="#{productName}">' +
            '</a>' +
        '</div>' +
        '<h2 class="product-name">' +
            '<a href="#{productUrl}" title="#{productName}">#{productName}</a>' +
        '</h2>' +
        '#{productPrice}' +
        '<div class="add-to-cart">' +
            '<button type="button" title="Add to Cart" class="button btn-cart" onclick="setLocation(\'#{productUrl}\')"><span><span>Add to Cart</span></span></button>' +
        '</div>' +
        '<ul class="add-to-links">' +
            '<li class="add-wishlist">' +
                '<a href="#{productWishList}" class="link-wishlist" onclick="return addToWishlistAjax(this.href);" title="Add to Wishlist"><span>Add to Wishlist</span></a>' +
            '</li>' +
            '<li class="add-compare">' +
                '<a href="#{productToCompare}" class="link-compare" onclick="return addToCompareAjax(this.href);" title="Add to Compare"><span>Add to Compare</span></a>' +
            '</li>' +
            '<li class="add-quick-view">' +
                '<a href="#" class="link-quick-view" data-url="/quickview/quickview/view/id/#{productId}"><span>Quick View</span></a>' +
            '</li>' +
        '</ul>' +
    '</div>';
'</div>';

var productTemplateList = '<div class="category-item">' +
    '<div class="products-item products-item-#{productId}">' +
        '<div class="products-item-img">' +
            '<a href="#{productUrl}" title="#{productName}" class="product-image">' +
                '<img class="img-responsive" src="#{productSmallImageUrl}" alt="#{productName}">' +
            '</a>' +
        '</div>' +
        '<div class="product-shop">' +
            '<h2 class="product-name">' +
                '<a href="#{productUrl}" title="#{productName}">#{productName}</a>' +
            '</h2>' +
            '#{productPrice}' +
            '<div class="add-to-cart">' +
                '<button type="button" title="Add to Cart" class="button btn-cart" onclick="setLocation(\'#{productUrl}\')"><span><span>Add to Cart</span></span></button>' +
            '</div>' +
            '<ul class="add-to-links">' +
                '<li class="add-wishlist">' +
                    '<a href="#{productWishList}" class="link-wishlist" onclick="return addToWishlistAjax(this.href);" title="Add to Wishlist"><span>Add to Wishlist</span></a>' +
                '</li>' +
                '<li class="add-compare">' +
                    '<a href="#{productToCompare}" class="link-compare" onclick="return addToCompareAjax(this.href);" title="Add to Compare"><span>Add to Compare</span></a>' +
                '</li>' +
                '<li class="add-quick-view">' +
                    '<a href="#" class="link-quick-view" data-url="/quickview/quickview/view/id/#{productId}"><span>Quick View</span></a>' +
                '</li>' +
            '</ul>' +
        '</div>' +
    '</div>';

var pages = '';

var ias = jQuery.ias({
    container: '.category-row',
    item: '.category-item',
    pagination: '#pagination-scroll',
    next: '.next-scroll',
    negativeMargin: 2000
});

ias.extension(new IASSpinnerExtension({
        html: '<span class="scroll-loading"></span>'
    })
);

ias.on('load', function (event) {
    event.url = jQuery('.next-scroll').attr('href');

    if ( !getParameterByName("scroll", event.url) ) {
        event.url = event.url + '&scroll=1';
    }

    if ( pages == '' ) {
        pages = getParameterByName("p", event.url) - 1;
    }

    pages += ',' + getParameterByName("p", event.url);

    event.url = event.url + '&pages=' + pages;
});

function getParameterByName(name, url) {
    url = url.toLowerCase();

    name = name.replace(/[\[\]]/g, "\\$&").toLowerCase();

    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),

        results = regex.exec(url);

    if (!results) return null;

    if (!results[2]) return '';

    return decodeURIComponent(results[2].replace(/\+/g, " "));
}


function getHtmlItems(data) {
    var result = JSON.parse(data);
    var collection = result.collection;
    var toolbar = result.toolbar;

    jQuery('.toolbar').replaceWith(toolbar);

    data = toolbar + '<div class="category-row">';

    data += getHtml(collection);

    return data + '</div>';
}

function getHtml(collection) {
    var data = '';
    var listMode = jQuery('input[type=hidden].check-list').data('list');
    var length = collection.length;
    var productTemplateObject;

    if (listMode == 1) {
        productTemplateObject = new Template(productTemplateList);
    } else {
        productTemplateObject = new Template(productTemplateGrid);
    }

    for ( var i = 0; i < length; i++ ) {
        var show = {
            productName: collection[i].productName,
            productId: collection[i].productId,
            productUrl: collection[i].productUrl,
            productSmallImageUrl: collection[i].productSmallImageUrl,
            productPrice: collection[i].productPrice,
            productToCompare: collection[i].productToCompare,
            productWishList: collection[i].productWishList,
            productDescription: collection[i].productDescription
        };

        data += productTemplateObject.evaluate(show);
    }

    return data;
}

