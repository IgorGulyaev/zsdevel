!function(t){"use strict";function a(){var a=t(document).height(),e=a-65;console.log(a),t("iframe#dropshix-frame").css({height:e})}function e(){if(t("input.dxorderitems").length){var a=t("input.dxorderitems").length;t("input.dxorderitems").each(function(){var a=t(this).attr("data-item-id"),e=t(this).attr("data-sku"),r=t(this).val(),i=t(this).attr("data-variation"),s=t(this).attr("id"),o=t('tr[data-order_item_id="'+a+'"]'),l='<td><a href="http://s.click.aliexpress.com/deep_link.htm?dp=bestprice&aff_short_key=BAYjyNRZZ&dl_target_url=https://www.aliexpress.com/item//'+e+'.html" target="_blank" data-var="'+i+'" data-q="'+r+'" data-id="'+s+'" class="button button-primary">Order Item</a></td>';o.append(l)}),console.log(a)}}t(window).resize(function(){a()}),t(function(){a(),e(),t("a#checkAddress").length&&t("a#checkAddress").click(function(a){a.preventDefault();var e=t(".shipping-details").attr("data-show");"hide"==e?(t(".shipping-details").fadeIn("slow",function(){t(".shipping-details").attr("data-show","show")}),t(this).text("x close")):(t(".shipping-details").fadeOut("slow",function(){t(".shipping-details").attr("data-show","hide")}),t(this).text("check shipping details"))}),t("#DXAttrWrapper").length&&(t("#scanAttr").click(function(a){a.preventDefault();var e="//dropshix.xolluteon.com/dropshix/api/v1/attr",r=t(this).attr("data-key"),i=e+"/"+r+"/browse/",s=t(this).attr("data-id"),o=i+s;console.log(o),t.fancybox.open({type:"iframe",src:o,iframe:{css:{width:"90%"}},opts:{afterShow:function(){console.info("done!")},afterClose:function(){t("#dxScanner").hide(),t("#dxImporter").show()}}})}),t("#importAttr").click(function(a){a.preventDefault();var e=t(this).attr("data-key"),r=t(this).attr("data-id");t.ajax({url:ajaxurl,type:"post",data:{action:"dropshixImportAtrr",key:e,wooid:r}}).fail(function(a,e){console.log(e),msgerror="Failed Load Data. ","undefined"!=typeof a.msg&&(msgerror=a.msg),t("."+type+"-wrap").html(msgerror)}).done(function(t,a,e){console.log(e.responseText);var r=e.responseText;1==r&&window.location.reload()})}))}),t(document).ready(function(){var a=t(".product_custom_field").find("#_product_url");if(a){var e=a.first().val(),r='<a href="'+e+'" target="_blank" class="btn btn-warning">Click here</a>';a.after(r),a.first().hide()}if(t("input#prepared").length){var i=t("input#prepared").val();"yes"===i&&t("input#publish")[0].click()}if(t("input#not_sale_product").length){var s=t("input#not_sale_product");s.on("change",function(){if(t("p#saleResult").slideDown("slow",function(){t(this).html("Processing...")}),s.prop("checked"))var a="no";else var a="yes";t.ajax({url:ajaxurl,type:"post",data:{action:"dshixDisableSale",sale:a,post:t("input#dshix_woo_id").val()},success:function(a){console.log(a),t("p#saleResult").removeClass("alert-warning"),t("p#saleResult").addClass("alert-success"),t("p#saleResult").html("Success!"),t("input#publish")[0].click()},error:function(a,e,r){console.log(r),t("p#saleResult").removeClass("alert-warning"),t("p#saleResult").addClass("alert-danger"),t("p#saleResult").html("Error!")}})})}if(t("div.nav-to-dropshix").length&&(t(".loading-layer").fadeIn("fast"),t("#dropshix-frame").on("load",function(){t(".loading-layer").fadeOut("slow")}),t("a.changeSupplier").each(function(){t(this).click(function(a){a.preventDefault(),t(".loading-layer").fadeIn("fast");var e=t(this).attr("data-source");console.log(e),t.ajax({url:ajaxurl,type:"post",data:{action:"Xox_Switch_URL",source:e}}).fail(function(t,a,e){console.log(e)}).done(function(a){t("#dropshix-frame").attr("src",a),t("#dropshix-frame").on("load",function(){t(".loading-layer").fadeOut("slow")})})})})),t("#tblInActive").length&&(t("#tblInActive").DataTable({dom:'<"top"<"clear">fl<"clear">>rt<"bottom"ip<"clear">>',buttons:["colvis","csv"],fixedHeader:{header:!0,headerOffset:t("#wpadminbar").height()}}),t("#tblInActive").on("click",".xox-archivethisfa",function(){var a=t(this).attr("data-id"),e=t(this).attr("data-source");t(this).html("Loading . . ."),t(".xox-archivethisfa-"+a).attr("disabled","disabled"),t.ajax({url:ajaxurl,type:"post",dataType:"json",data:{action:"Xox_Archive_Item",id:a,source:e}}).fail(function(){var e='<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong>Failed Archiving Data. </div>';t(".action-"+a).prepend(e),t(".xox-archivethisfa-"+a).html("Archive"),t(".xox-archivethisfa-"+a).removeAttr("disabled")}).done(function(e){if(1==e.status)alert("Item Successfully Archived"),t("tr#ic-"+a).remove();else{var r='<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong>Failed Archiving Data. </div>';t("td#action-"+a).prepend(r),t(".xox-archivethisfa-"+a).html("Archive"),t(".xox-archivethisfa-"+a).removeAttr("disabled")}})})),t("#tblActive").length&&(t("#tblActive").DataTable({dom:'<"top"<"clear">fl<"clear">>rt<"bottom"ip<"clear">>',buttons:["colvis","csv"],fixedHeader:{header:!0,headerOffset:t("#wpadminbar").height()}}),t("#tblActive").on("click",".xox-deletethisfa",function(){var a=t(this).attr("data-id"),e=t(this).attr("data-source");t(this).html("Loading . . ."),t.ajax({url:ajaxurl,type:"post",dataType:"json",data:{action:"Xox_Delete_Item",id:a,source:e}}).fail(function(){var e='<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong>Failed Delete Data. </div>';t(".action-"+a).prepend(e),t(".xox-deletethisfa-"+a).html("Remove"),t(".xox-importthisfa-"+a).removeAttr("disabled")}).done(function(e){if(1==e.status)alert("Item Successfully Removed"),t("tr#a"+a).remove();else{var r='<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong>Failed Delete Data. </div>';t(".action-"+a).prepend(r),t(".xox-deletethisfa-"+a).html("Remove"),t(".xox-importthisfa-"+a).removeAttr("disabled")}})})),t("#tblPending").length){t("#tblPending").DataTable({dom:'<"top"<"clear">fl<"clear">>rt<"bottom"ip<"clear">>',buttons:["colvis","csv"],fixedHeader:{header:!0,headerOffset:t("#wpadminbar").height()}});var o=t("input#dlevel").val();t("#tblPending").on("click","p .xox-import",function(){var a=t(this).attr("data-id"),e=t("#desc-"+a).val(),r=t(this).attr("data-title"),i=t(this).attr("data-source"),s=t("input#dshix_url").val();t(this).hide("fast"),t(this).parent("p").html('<img src="'+s+'/css/dshixloading.gif"> Importing product.'),t(".xox-deletethis-"+a).hide(),t.ajax({url:ajaxurl,type:"post",dataType:"json",data:{action:"Xox_Import_Item",id:a,description:e,title:r,source:i}}).fail(function(e){var r="Failed Import Data. ";"undefined"!=typeof e.msg&&(r=e.msg);var i='<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> '+r+"</div>";t("#action-"+a).prepend(i),t(".xox-deletethis-"+a).show()}).done(function(e){if(console.log(e),1==e.status){var r='<p><a href="'+e.url+'&dsprepared=yes" target="_blank" class="btn btn-warning">Edit item.</a></p>',l='<p><a href="'+e.view+'" target="_blank" class="btn btn-primary">View item.</a></p>',n=parseInt(t("span#itemActive").html()),d=n+1;if(t("span#itemActive").html(d),"ae"==i&&o>=50){t("td#action-"+a).empty(),t("td#action-"+a).html('<p><img src="'+s+'/css/dshixloading.gif"> Importing attributes.</p>');var c=e.wooid;t.ajax({url:ajaxurl,type:"post",data:{action:"importAtrrVar",wooid:c},success:function(e){console.log(e),t("td#action-"+a).empty(),t("td#action-"+a).append(r),t("td#action-"+a).append(l)},error:function(t){console.log(t)}})}else if("amus"==i){var p='<div class="alert alert-warning"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> The source store (AMAZON) does not support auto import for variations.</div>';t("td#action-"+a).empty(),t("td#action-"+a).prepend(p),t("td#action-"+a).append(r),t("td#action-"+a).append(l)}else{var p='<div class="alert alert-warning"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Your current package does not support auto import for attributes, please import attributes manually or upgrade your package.</div>';t("td#action-"+a).empty(),t("td#action-"+a).prepend(p),t("td#action-"+a).append(r),t("td#action-"+a).append(l)}}else{var h="Failed Import Data. ";"undefined"!=typeof e.msg&&(h=e.msg);var p='<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> '+h+"</div>";t("#action-"+a).prepend(p),t(".xox-importthis-"+a).html("Import This Item"),t(".xox-deletethis-"+a).show()}})}),t("#tblPending").on("click",".removequeue",function(){var a=t(this).attr("data-id"),e=t(this).attr("data-source");t(this).html("Loading . . ."),t("#xox-importthis-"+a).attr("disabled","disabled"),t.ajax({url:ajaxurl,type:"post",dataType:"json",data:{action:"Xox_Delete_Item",id:a,source:e}}).fail(function(){var e='<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong>Failed Delete Data. </div>';t(".action-"+a).prepend(e),t(".xox-deletethis-"+a).html("Remove This Item"),t(".xox-importthis-"+a).removeAttr("disabled"),t("#loading-import-remove").addClass("hide")}).done(function(e){if(1==e.status)alert("Item Successfully Removed"),t("#q"+a).length&&t("#q"+a).remove();else{var r='<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong>Failed Delete Data. </div>';t(".action-"+a).prepend(r),t(".xox-deletethis-"+a).html("Remove This Item"),t(".xox-importthis-"+a).removeAttr("disabled")}})})}})}(jQuery);