{% assign add_to_cart = 'Add to cart' %}
{% assign sold_out = 'Sold Out' %}
{% assign unavailable = 'Unavailable' %}

<div itemscope itemtype="http://schema.org/Product">
  
  <meta itemprop="url" content="{{ shop.url }}{{ product.url }}" />
  <meta itemprop="image" content="{{ product | img_url: '720x720', scale: 2 }}" />
  
  {% comment %}
  *
  * PRODUCT FORM
  * 
  {% endcomment %}
  <form action="/cart/add" method="post" class="single-product" enctype="multipart/form-data" id="add-to-cart">
    <div class="row">
      <div class="images">
        

        <a class="control next">
          <svg xmlns="http://www.w3.org/2000/svg" width="17.434" height="33.454" viewBox="0 0 17.434 33.454">
            <g id="Group_25" data-name="Group 25" transform="translate(0.707 0.707)">
              <path id="Line_10" data-name="Line 10" d="M15.313,16.727-.707.707.707-.707l16.02,16.02Z" transform="translate(0)"/>
              <path id="Line_11" data-name="Line 11" d="M.707,16.727-.707,15.313,15.313-.707,16.727.707Z" transform="translate(0 16.02)"/>
            </g>
          </svg>
        </a>
        <a class="control prev">
          <svg xmlns="http://www.w3.org/2000/svg" width="17.434" height="33.454" viewBox="0 0 17.434 33.454">
            <g id="Group_25" data-name="Group 25" transform="translate(0.707 0.707)">
              <path id="Line_10" data-name="Line 10" d="M15.313,16.727-.707.707.707-.707l16.02,16.02Z" transform="translate(0)"/>
              <path id="Line_11" data-name="Line 11" d="M.707,16.727-.707,15.313,15.313-.707,16.727.707Z" transform="translate(0 16.02)"/>
            </g>
          </svg>
        </a>

        {% comment %}
          PRODUCT IMAGE or GALLERY or PLACEHOLDER
        {% endcomment %}
        <ul class="image-list">
          {% if product.images.size == 0 %}

              <li class="placeholder">
                <img src="{{ '' | img_url: 'master' }}" alt="{{ product.title }}" />
              </li>

          {% else %}
          
              {% assign featured_image = product.selected_or_first_available_variant.featured_image | default: product.featured_image %}
  
              {% if product.images.size > 1 %}
    
                  {% for image in product.images %}
                      <li class="gallery-image" itemprop="image">
                        <img class="image-zoom" src="{{ image | img_url: 'master' }}" alt="{{ image.alt | escape }}" />
                      </li>
                      <div class="image-details"></div>
                  {% endfor %}
  
              {% else %}
  
                  <li class="featured-image" itemprop="image">
                    <img class="image-zoom" src="{{ featured_image | img_url: 'master' }}" alt="{{ product.title | escape }}" />
                  </li>
                  <div class="image-details"></div>

              {% endif %}

          {% endif %}
        </ul>
      </div>

        {% comment %}
          TITLE
        {% endcomment %}
        <div class="title" itemprop="name">
          <h1>{{ product.title }}</h1>
        </div>

        {% comment %}
          DESCRIPTION
        {% endcomment %}
        <div class="description" itemprop="description">
          <p>{{ product.description }}</p>
        </div>
        
        {% comment %}
          PRICE
        {% endcomment %}
        <div id="product-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
          <meta itemprop="priceCurrency" content="{{ shop.currency }}" />
          {% if product.available %}
            <link itemprop="availability" href="http://schema.org/InStock" />
          {% else %}
            <link itemprop="availability" href="http://schema.org/OutOfStock" />
          {% endif %}
          <p>
            {% assign variant = product.selected_or_first_available_variant %}
            {% if product.compare_at_price > product.price %}
              <span class="product-price on-sale" itemprop="price">{{ variant.price | money }}</span>
              <s class="product-compare-price">{{ variant.compare_at_price | money }}</s>
            {% else %}
              <span class="product-price" itemprop="price">{{ variant.price | money }}</span>
            {% endif %}
          </p>
        </div>
          
    

        {% comment %}
          VARIANT RADIO BUTTONS
        {% endcomment %}
        {% assign hide_default_title = false %}
        {% if product.variants.size == 1 and product.variants.first.title contains 'Default' %}
          {% assign hide_default_title = true %}
        {% endif %}   

        {% if product.variants.size > 1 %} 

          <ul class="variants-list">
            {% assign found_available_variant = false %}
            {% for variant in product.variants %}
              <li class="switch-field">
                  {% if variant.available %}
                      <input type="radio"{% if variant.compare_at_price > variant.price %} data-compare-at-price="{{ variant.compare_at_price | money_with_currency }}"{% endif %} data-price="{{ variant.price | money_with_currency }}" id="{{ variant.id }}" value="{{ variant.id }}" name="id"{% if found_available_variant == false  %}{% assign found_available_variant = true %} checked="checked"{% endif %} />
                      
                      <label for="{{ variant.id }}">
                        {{ variant.title }}
                      </label>
                  {% else %}
                      <input type="radio" class="out-of-stock" id="{{ variant.id }}" value="{{ variant.id }}" name="id" />
                      <label for="{{ variant.id }}" class="out-of-stock">
                        {{ variant.title }}
                      </label>
                  {% endif %}
                </li>
            {% endfor %}
          </ul>

        {% else %}
      
            <input type="hidden" name="id" value="{{ product.variants.first.id }}" />
      
        {% endif %}
          
        {% comment %}
          ADD TO CART
        {% endcomment %}
        <div id="product-add">
          <input type="submit" name="add" id="add" value="{{ add_to_cart | escape }}">
        </div>

        {% comment %}
          IN STOCK?
        {% endcomment %}
        <div class="final-details">
          <p class="am-i-in-stock">&nbsp;</p>
          <a class="size-chart" href={{ 'wald_size_chart.pdf' |  asset_url }} title="Size chart">Download Size Chart</a>
        </div>

        {% comment %}
          SUCCESS / ERROR
        {% endcomment %}
        <div data-ajax-cart-messages="form"> 
          <!-- Errors and messages appear here --> 
        </div>

        {% if form.posted_successfully? %}
            <script>console.log('Comment posted successfully!');</script>
        {% else %}
            {{ form.errors | default_errors }}
        {% endif %}

  


    {% comment %}
      REVIEWS
      https://apps.shopify.com/product-reviews
    {% endcomment %}
    <div id="shopify-product-reviews" data-id="{{ product.id }}">
      {{ product.metafields.spr.reviews }}
    </div>
        
    {% comment %}
      PAGINATION
    {% endcomment %}
    <div class="pagination">
      {% if collection %}

        {% if collection.previous_product or collection.next_product %}
          <div>     
            {% if collection.previous_product %}
              {% capture prev_url %}{{ collection.previous_product}}#content{% endcapture %}
              <span class="left">{{ 'Previous Product' | link_to: prev_url }}</span>
            {% endif %}

            {% if collection.next_product %}
              {% capture next_url %}{{ collection.next_product}}#content{% endcapture %}
              <span class="right">{{ 'Next Product' | link_to: next_url }}</span>
            {% endif %}
          </div>
        {% endif %}

      {% endif %}
    </div>

  </form>

</div>

{% comment %}
  PRELOAD IMAGES
{% endcomment %}
<script>
  Shopify.Image.preload({{ product.images | json }}, 'grande');
  Shopify.Image.preload({{ product.images | json }}, '1024x1024');
</script>

{% comment %}
  RADIO BUTTON FUNCTIONS
{% endcomment %}
<script type="text/javascript" charset="utf-8">
  jQuery(function() { 
    var first_variant_price = jQuery("ul li input[type='radio']:checked").attr("data-price");
    var first_variant_compare_at_price = jQuery("ul li input[type='radio']:checked").attr("data-compare-at-price") || ''; 

    jQuery(".price-field span").html(first_variant_price);

    jQuery(".price-field del").html(first_variant_compare_at_price);

    jQuery("input[type='radio']").click(function() {

      var variant_price = jQuery(this).attr("data-price");
      jQuery(".price-field span").html(variant_price);
      
      var variant_compare_at_price = jQuery(this).attr("data-compare-at-price") || '';
      jQuery(".price-field del").html(variant_compare_at_price);

    });
  });
</script>

{% comment %}
  IN STOCK? FUNCTIONS
{% endcomment %}
<script>
  jQuery('.switch-field').on('change', function() {

    var theProduct = {{ product | json }};
    var selectedVariant = jQuery('input[type=radio]:checked').val();

    for (var i = 0; i < theProduct.variants.length; i++) {
        if (theProduct.variants[i].id == selectedVariant) {
            
            var final =  theProduct.variants[i].available;
            if ( final == true) {
              jQuery('.am-i-in-stock').text('Available now');
            } else {
              jQuery('.am-i-in-stock').text('Made to order');
            }
            
            console.log(theProduct.variants[i].available);
        }
    }
    
    console.log(theProduct.variants.selectedVariant);

    console.log(theProduct);
    console.log( 'Selected Variant ID: ' + selectedVariant);
    console.log('All variants: ' + theProduct.variants);
    console.log('A specific variant by ID: ' + theProduct.variants[0].id)
  
    
  });
</script>

{% comment %}
  GALLERY IMAGE ZOOM
{% endcomment %}
<script>
  $(document).ready(function(){
    $('.image-zoom')
    .wrap('<span style="display:inline-block"></span>')
    .css('display', 'block')
    .parent()
    .zoom({
      url: $(this).find('img').attr('data-zoom')
    });
  });
</script>

{% comment %}
  CALL FUNCTION ON 'ADD TO CART'
{% endcomment %}
<script>
    jQuery('form.single-product').on('submit', function() {
      // Your function
    });
</script>






{% comment %}
  FILE CONTENTS: liquid-ajax-cart-v1.9.0.js
{% endcomment %}
<script>
  var t={d:(e,r)=>{for(var o in r)t.o(r,o)&&!t.o(e,o)&&Object.defineProperty(e,o,{enumerable:!0,get:r[o]})},o:(t,e)=>Object.prototype.hasOwnProperty.call(t,e)},e={};t.d(e,{x$:()=>V,nd:()=>K,yF:()=>X,fi:()=>Q,Be:()=>z,ih:()=>G,KJ:()=>Z,Q4:()=>Y,WP:()=>et,w0:()=>tt});const r=[];function o(t){switch(t){case"add":return"/cart/add.js";case"change":return"/cart/change.js";case"get":return"/cart.js";case"clear":return"/cart/clear.js";case"update":return"/cart/update.js";default:return}}function n(t,e,n){const i=o(t);let s;"get"!==t&&(s=e||{});const c="get"===t?"GET":"POST",u=n.info||{},l="firstComplete"in n?[n.firstComplete]:[],d={requestType:t,endpoint:i,requestBody:s,info:u},p=[];if(r.forEach((e=>{try{e({requestType:t,endpoint:i,info:u,requestBody:s},(t=>{l.push(t)}))}catch(t){console.error("Liquid Ajax Cart: Error during Ajax request subscriber callback in ajax-api"),console.error(t)}})),void 0!==s){let t;if(s instanceof FormData||s instanceof URLSearchParams?s.has("sections")&&(t=s.get("sections").toString()):t=s.sections,"string"==typeof t||t instanceof String||Array.isArray(t)){const e=[];if(Array.isArray(t)?e.push(...t):e.push(...t.split(",")),e.length>5){p.push(...e.slice(5));const t=e.slice(0,5).join(",");s instanceof FormData||s instanceof URLSearchParams?s.set("sections",t):s.sections=t}}else null!=t&&console.error(`Liquid Ajax Cart: "sections" parameter in a Cart Ajax API request must be a string or an array. Now it is ${t}`)}"lastComplete"in n&&l.push(n.lastComplete);const f={method:c};"get"!==t&&(s instanceof FormData||s instanceof URLSearchParams?(f.body=s,f.headers={"x-requested-with":"XMLHttpRequest"}):(f.body=JSON.stringify(s),f.headers={"Content-Type":"application/json"})),fetch(i,f).then((t=>t.json().then((e=>({ok:t.ok,status:t.status,body:e}))))).then((e=>(d.responseData=e,"add"!==t&&0===p.length||!d.responseData.ok?d:a(p).then((t=>(d.extraResponseData=t,d)))))).catch((t=>{console.error("Liquid Ajax Cart: Error while performing cart Ajax request"),console.error(t),d.fetchError=t})).finally((()=>{l.forEach((t=>{try{t(d)}catch(t){console.error("Liquid Ajax Cart: Error during Ajax request result callback in ajax-api"),console.error(t)}}))}))}function a(t=[]){const e={};return t.length>0&&(e.sections=t.slice(0,5).join(",")),fetch(o("update"),{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify(e)}).then((e=>e.json().then((r=>{const o={ok:e.ok,status:e.status,body:r};return t.length<6?o:a(t.slice(5)).then((t=>{var e;return t.ok&&(null===(e=t.body)||void 0===e?void 0:e.sections)&&"object"==typeof t.body.sections&&("sections"in o.body||(o.body.sections={}),o.body.sections=Object.assign(Object.assign({},o.body.sections),t.body.sections)),o}))}))))}function i(t={}){n("get",void 0,t)}function s(t={},e={}){n("add",t,e)}function c(t={},e={}){n("change",t,e)}function u(t={},e={}){n("update",t,e)}function l(t={},e={}){n("clear",t,e)}function d(t){r.push(t)}let p=0;const f=[];let m,y=null,h={requestInProgress:!1,cartStateSet:!1};function b(t){const{attributes:e,items:r,item_count:o}=t;if(null==e||"object"!=typeof e)return null;if("number"!=typeof o&&!(o instanceof Number))return null;if(!Array.isArray(r))return null;const n=[];for(let t=0;t<r.length;t++){const e=r[t];if("number"!=typeof e.id&&!(e.id instanceof Number))return null;if("string"!=typeof e.key&&!(e.key instanceof String))return null;if("number"!=typeof e.quantity&&!(e.quantity instanceof Number))return null;if(!("properties"in e))return null;n.push(Object.assign(Object.assign({},e),{id:e.id,key:e.key,quantity:e.quantity,properties:e.properties}))}return Object.assign(Object.assign({},t),{attributes:e,items:n,item_count:o})}const g=()=>{h.requestInProgress=p>0,h.cartStateSet=null!==y,S()};function q(t){f.push(t)}function A(){return{cart:y,status:h}}const S=()=>{f.forEach((t=>{try{const e={cart:y,status:h};void 0!==m&&(e.previousCart=m),t(e)}catch(t){console.error("Liquid Ajax Cart: Error during a call of a cart state update subscriber"),console.error(t)}}))};function C(t){const{binderAttribute:e}=v.computed;t.status.cartStateSet&&document.querySelectorAll(`[${e}]`).forEach((t=>{const r=t.getAttribute(e);t.textContent=function(t){const{stateBinderFormatters:e}=v,{binderAttribute:r}=v.computed,[o,...n]=t.split("|");let a=j(o,A());return n.forEach((t=>{const r=t.trim();""!==r&&("object"==typeof e&&r in e?a=e[r](a):r in x?a=x[r](a):console.warn(`Liquid Ajax Cart: the "${r}" formatter is not found`))})),"string"==typeof a||a instanceof String||"number"==typeof a||a instanceof Number?a.toString():(console.error(`Liquid Ajax Cart: the calculated value for the ${r}="${t}" element must be string or number. But the value is`,a),"")}(r)}))}function j(t,e){const r=t.split("."),o=r.shift().trim();return""!==o&&o in e&&r.length>0?j(r.join("."),e[o]):e[o]}const x={money_with_currency:t=>{var e;const r=A();if("number"!=typeof t&&!(t instanceof Number))return console.error("Liquid Ajax Cart: the 'money_with_currency' formatter is not applied because the value is not a number. The value is ",t),t;const o=t/100;return"Intl"in window&&(null===(e=window.Shopify)||void 0===e?void 0:e.locale)?Intl.NumberFormat(window.Shopify.locale,{style:"currency",currency:r.cart.currency}).format(o):`${o.toFixed(2)} ${r.cart.currency}`}},v={productFormsFilter:t=>!0,messageBuilder:t=>{let e="";return t.forEach((t=>{e+=`<div class="js-ajax-cart-message js-ajax-cart-message--${t.type}">${t.text}</div>`})),e},stateBinderFormatters:{},addToCartCssClass:"",lineItemQuantityErrorText:"You can't add more of this item to your cart",requestErrorText:"There was an error while updating your cart. Please try again.",updateOnWindowFocus:!0,computed:{productFormsErrorsAttribute:"data-ajax-cart-form-error",sectionsAttribute:"data-ajax-cart-section",staticElementAttribute:"data-ajax-cart-static-element",binderAttribute:"data-ajax-cart-bind-state",requestButtonAttribute:"data-ajax-cart-request-button",toggleClassButtonAttribute:"data-ajax-cart-toggle-class-button",initialStateAttribute:"data-ajax-cart-initial-state",sectionScrollAreaAttribute:"data-ajax-cart-section-scroll",quantityInputAttribute:"data-ajax-cart-quantity-input",propertyInputAttribute:"data-ajax-cart-property-input",messagesAttribute:"data-ajax-cart-messages",configurationAttribute:"data-ajax-cart-configuration",cartStateSetBodyClass:"js-ajax-cart-set",requestInProgressBodyClass:"js-ajax-cart-request-in-progress",emptyCartBodyClass:"js-ajax-cart-empty",notEmptyCartBodyClass:"js-ajax-cart-not-empty",productFormsProcessingClass:"js-ajax-cart-form-in-progress"}};function L(t,e){t in v&&"computed"!==t?(v[t]=e,"stateBinderFormatters"===t&&C(A())):console.error(`Liquid Ajax Cart: unknown configuration parameter "${t}"`)}const w=[];function $(t,e){const{requestButtonAttribute:r}=v.computed;let o;const n=["/cart/change","/cart/add","/cart/clear","/cart/update"];if(!t.hasAttribute(r))return;const a=t.getAttribute(r);if(a){let t;try{if(t=new URL(a,window.location.origin),!n.includes(t.pathname))throw"URL should be one of the following: /cart/change, /cart/add, /cart/update, /cart/clear";o=t}catch(t){console.error(`Liquid Ajax Cart: ${r} contains an invalid URL as a parameter.`,t)}}else if(t instanceof HTMLAnchorElement&&t.hasAttribute("href")){const e=new URL(t.href);n.includes(e.pathname)?o=e:t.hasAttribute(r)&&console.error(`Liquid Ajax Cart: a link with the ${r} contains an invalid href URL.`,"URL should be one of the following: /cart/change, /cart/add, /cart/update, /cart/clear")}if(void 0===o)return void console.error(`Liquid Ajax Cart: a ${r} element doesn't have a valid URL`);if(e&&e.preventDefault(),A().status.requestInProgress)return;const i=new FormData;switch(o.searchParams.forEach(((t,e)=>{i.append(e,t)})),o.pathname){case"/cart/add":s(i,{info:{initiator:t}});break;case"/cart/change":c(i,{info:{initiator:t}});break;case"/cart/update":u(i,{info:{initiator:t}});break;case"/cart/clear":l({},{info:{initiator:t}})}}function E(t,e){let r,o;return e.status.cartStateSet&&(t.length>3?(r=e.cart.items.find((e=>e.key===t)),o="id"):(r=e.cart.items[Number(t)-1],o="line"),void 0===r&&(r=null,console.error(`Liquid Ajax Cart: line item with ${o}="${t}" not found`))),[r,o]}function T(t){const{quantityInputAttribute:e}=v.computed;return!!t.hasAttribute(e)&&(t instanceof HTMLInputElement&&("text"===t.type||"number"===t.type)||(console.error(`Liquid Ajax Cart: the ${e} attribute supports "input" elements only with the "text" and the "number" types`),!1))}function k(t){const{quantityInputAttribute:e}=v.computed;t.status.requestInProgress?document.querySelectorAll(`input[${e}]`).forEach((t=>{T(t)&&(t.disabled=!0)})):document.querySelectorAll(`input[${e}]`).forEach((r=>{if(!T(r))return;const o=r.getAttribute(e).trim(),[n]=E(o,t);n?r.value=n.quantity.toString():null===n&&(r.value="0"),r.disabled=!1}))}function B(t,e){const{quantityInputAttribute:r}=v.computed;if(!T(t))return;if(e&&e.preventDefault(),A().status.requestInProgress)return;let o=Number(t.value.trim());const n=t.getAttribute(r).trim();if(isNaN(o))return void console.error("Liquid Ajax Cart: input value of a data-ajax-cart-quantity-input must be an Integer number");if(o<1&&(o=0),!n)return void console.error("Liquid Ajax Cart: attribute value of a data-ajax-cart-quantity-input must be an item key or an item index");const a=n.length>3?"id":"line",i=new FormData;i.set(a,n),i.set("quantity",o.toString()),c(i,{info:{initiator:t}}),t.blur()}function D(t){const{propertyInputAttribute:e}=v.computed,r=t.getAttribute(e),o=t.getAttribute("name");console.error(`Liquid Ajax Cart: the element [${e}="${r}"]${o?`[name="${o}"]`:""} has wrong attributes.`)}function R(t){const{propertyInputAttribute:e}=v.computed;return!!t.hasAttribute(e)&&(t instanceof HTMLInputElement&&"hidden"!==t.type||t instanceof HTMLTextAreaElement||t instanceof HTMLSelectElement)}function N(t){const{propertyInputAttribute:e}=v.computed,r={objectCode:void 0,propertyName:void 0,attributeValue:void 0};if(!t.hasAttribute(e))return r;let o=t.getAttribute(e).trim();if(!o){const e=t.getAttribute("name").trim();e&&(o=e)}if(!o)return D(t),r;if(r.attributeValue=o,"note"===o)return r.objectCode="note",r;let[n,...a]=o.trim().split("[");return!a||1!==a.length||a[0].length<2||a[0].indexOf("]")!==a[0].length-1?(D(t),r):(r.objectCode=n,r.propertyName=a[0].replace("]",""),r)}function F(t){const{propertyInputAttribute:e}=v.computed;t.status.requestInProgress?document.querySelectorAll(`[${e}]`).forEach((t=>{R(t)&&(t.disabled=!0)})):document.querySelectorAll(`[${e}]`).forEach((r=>{if(!R(r))return;const{objectCode:o,propertyName:n,attributeValue:a}=N(r);if(!o)return;if(!t.status.cartStateSet)return;let i,s=!1;if("note"===o)i=t.cart.note;else if("attributes"===o)i=t.cart.attributes[n];else{const[r,c]=E(o,t);r&&(i=r.properties[n]),null===r&&(console.error(`Liquid Ajax Cart: line item with ${c}="${o}" was not found when the [${e}] element with "${a}" value tried to get updated from the State`),s=!0)}r instanceof HTMLInputElement&&("checkbox"===r.type||"radio"===r.type)?r.value===i?r.checked=!0:r.checked=!1:("string"==typeof i||i instanceof String||"number"==typeof i||i instanceof Number||(Array.isArray(i)||i instanceof Object?(i=JSON.stringify(i),console.warn(`Liquid Ajax Cart: the ${e} with the "${a}" value is bound to the ${n} ${"attributes"===o?"attribute":"property"} that is not string or number: ${i}`)):i=""),r.value=i),s||(r.disabled=!1)}))}function I(t,e){const{propertyInputAttribute:r}=v.computed;if(!R(t))return;e&&e.preventDefault(),t.blur();const o=A();if(!o.status.cartStateSet)return;if(o.status.requestInProgress)return;const{objectCode:n,propertyName:a,attributeValue:i}=N(t);if(!n)return;let s=t.value;if(t instanceof HTMLInputElement&&"checkbox"===t.type&&!t.checked){let t=document.querySelector(`input[type="hidden"][${r}="${i}"]`);t||"note"!==n&&"attributes"!==n||(t=document.querySelector(`input[type="hidden"][${r}][name="${i}"]`)),s=t?t.value:""}if("note"===n){const e=new FormData;e.set("note",s),u(e,{info:{initiator:t}})}else if("attributes"===n){const e=new FormData;e.set(`attributes[${a}]`,s),u(e,{info:{initiator:t}})}else{const[e,u]=E(n,o);if(null===e&&console.error(`Liquid Ajax Cart: line item with ${u}="${n}" was not found when the [${r}] element with "${i}" value tried to update the cart`),!e)return;const l=Object.assign({},e.properties);l[a]=s;const d=new FormData;let p=d;d.set(u,n),d.set("quantity",e.quantity.toString());for(let t in l){const r=l[t];"string"==typeof r||r instanceof String?d.set(`properties[${t}]`,l[t]):p={[u]:n,quantity:e.quantity,properties:l}}c(p,{info:{initiator:t}})}}function O(t,e){const{toggleClassButtonAttribute:r}=v.computed;if(!t.hasAttribute(r))return;e&&e.preventDefault();const o=t.getAttribute(r).split("|");if(!o)return void console.error("Liquid Ajax Cart: Error while toggling body class");const n=o[0].trim();let a=o[1]?o[1].trim():"toggle";if("add"!==a&&"remove"!==a&&(a="toggle"),n)try{"add"===a?document.body.classList.add(n):"remove"===a?document.body.classList.remove(n):document.body.classList.toggle(n)}catch(e){console.error("Liquid Ajax Cart: Error while toggling body class:",n),console.error(e)}}const P=new WeakMap;function H(t){const e=P.get(t);v.computed.productFormsProcessingClass&&(e>0?t.classList.add(v.computed.productFormsProcessingClass):t.classList.remove(v.computed.productFormsProcessingClass))}const M=(t,e)=>{var r;const{messagesAttribute:o}=v.computed;let n,a,i,s,c,u,l=[];const d=A();if(t.requestBody instanceof FormData||t.requestBody instanceof URLSearchParams?(t.requestBody.has("line")&&(a=t.requestBody.get("line").toString()),t.requestBody.has("id")&&(n=t.requestBody.get("id").toString()),t.requestBody.has("quantity")&&(i=Number(t.requestBody.get("quantity").toString()))):("line"in t.requestBody&&(a=String(t.requestBody.line)),"id"in t.requestBody&&(n=String(t.requestBody.id)),"quantity"in t.requestBody&&(i=Number(t.requestBody.quantity))),a){const t=Number(a);t>0&&d.status.cartStateSet&&(s=t-1,n=null===(r=d.cart.items[s])||void 0===r?void 0:r.key)}if(n){if(d.status.cartStateSet&&(d.cart.items.forEach((t=>{t.key!==n&&t.id!==Number(n)||l.push(t)})),u=d.cart.item_count),n.indexOf(":")>-1)void 0===a&&1===l.length&&(a=l[0].key),c=document.querySelectorAll(`[${o}="${n}"]`);else{const t=l.map((t=>`[${o}="${t.key}"]`));c=document.querySelectorAll(t.join(","))}c.length>0&&c.forEach((t=>{t.innerHTML=""}))}e((t=>{var e;const{lineItemQuantityErrorText:r,messageBuilder:o}=v,{messagesAttribute:a}=v.computed;let s=[];const c=[];let l;if(null===(e=t.responseData)||void 0===e?void 0:e.ok){n&&(s=t.responseData.body.items.reduce(((t,e)=>(e.key!==n&&e.id!=Number(n)||t.push(e),t)),[])),s.forEach((e=>{!isNaN(i)&&e.quantity<i&&u===t.responseData.body.item_count&&c.push(e)}));const e=c.reduce(((t,e)=>(t.push(`[${a}="${e.key}"]`),t)),[]);e.length>0&&(l=document.querySelectorAll(e.join(","))),l&&l.length>0&&l.forEach((e=>{e.innerHTML=o([{type:"error",text:r,code:"line_item_quantity_error",requestState:t}])}))}else{const e=_(t);if(n)if(n.indexOf(":")>-1)l=document.querySelectorAll(`[${a}="${n}"]`);else{s=[];const t=A();t.status.cartStateSet&&t.cart.items.forEach((t=>{t.key!==n&&t.id!==Number(n)||s.push(t)}));const e=s.map((t=>`[${a}="${t.key}"]`));l=document.querySelectorAll(e.join(","))}l&&l.length>0&&l.forEach((t=>{t.innerHTML=o([e])}))}}))},U=(t,e)=>{var r;const o=null===(r=t.info)||void 0===r?void 0:r.initiator;let n;o instanceof HTMLFormElement&&(n=o.querySelectorAll(`[${v.computed.messagesAttribute}="form"]`),n.length>0&&n.forEach((t=>{t.innerHTML=""}))),e((t=>{const{messageBuilder:e}=v,r=_(t);r&&n&&n.forEach((t=>{t.innerHTML=e([r])}))}))};function _(t){var e;const{requestErrorText:r}=v;if(!(null===(e=t.responseData)||void 0===e?void 0:e.ok)){if("responseData"in t){if("description"in t.responseData.body)return{type:"error",text:t.responseData.body.description,code:"shopify_error",requestState:t};if("message"in t.responseData.body)return{type:"error",text:t.responseData.body.message,code:"shopify_error",requestState:t}}return{type:"error",text:r,code:"request_error",requestState:t}}}function J(t){const{cartStateSetBodyClass:e,requestInProgressBodyClass:r,emptyCartBodyClass:o,notEmptyCartBodyClass:n}=v.computed;e&&(t.status.cartStateSet?document.body.classList.add(e):document.body.classList.remove(e)),r&&(t.status.requestInProgress?document.body.classList.add(r):document.body.classList.remove(r)),o&&(t.status.cartStateSet&&0===t.cart.item_count?document.body.classList.add(o):document.body.classList.remove(o)),n&&(t.status.cartStateSet&&0===t.cart.item_count?document.body.classList.remove(n):document.body.classList.add(n))}let W;"liquidAjaxCart"in window||(function(){const t=document.querySelector(`[${v.computed.configurationAttribute}]`);if(t)try{const e=JSON.parse(t.textContent),r=["productFormsFilter","messageBuilder"];for(let t in e)r.includes(t)?console.error(`Liquid Ajax Cart: the "${t}" parameter is not supported inside the "${v.computed.configurationAttribute}" script — use the "configureCart" function for it`):L(t,e[t])}catch(t){console.error(`Liquid Ajax Cart: can't parse configuration JSON from the "${v.computed.configurationAttribute}" script`),console.error(t)}}(),document.addEventListener("submit",(t=>{const e=t.target;let r;if("/cart/add"!==new URL(e.action).pathname)return;if("productFormsFilter"in v&&!v.productFormsFilter(e))return;if(t.preventDefault(),r=P.get(e),r>0||(r=0),r>0)return;const o=new FormData(e);P.set(e,r+1),H(e),s(o,{lastComplete:t=>{const r=P.get(e);r>0&&P.set(e,r-1),H(e)},info:{initiator:e}})})),d(((t,e)=>{const{sectionsAttribute:r,staticElementAttribute:o,sectionScrollAreaAttribute:n}=v.computed;if(void 0!==t.requestBody){const e=[];if(document.querySelectorAll(`[${r}]`).forEach((t=>{const o=t.closest('[id^="shopify-section-"]');if(o){const t=o.id.replace("shopify-section-","");-1===e.indexOf(t)&&e.push(t)}else console.error(`Liquid Ajax Cart: there is a ${r} element that is not inside a Shopify section. All the ${r} elements must be inside Shopify sections.`)})),e.length){let r,o=e.join(",");t.requestBody instanceof FormData||t.requestBody instanceof URLSearchParams?t.requestBody.has("sections")&&(r=t.requestBody.get("sections").toString()):r=t.requestBody.sections,(("string"==typeof r||r instanceof String)&&""!==r||Array.isArray(r)&&r.length>0)&&(o=`${r.toString()},${o}`),t.requestBody instanceof FormData||t.requestBody instanceof URLSearchParams?t.requestBody.set("sections",o):t.requestBody.sections=o}}e((t=>{var e,r,n;const{sectionsAttribute:a,sectionScrollAreaAttribute:i}=v.computed,s=new DOMParser,c=[];if((null===(e=t.responseData)||void 0===e?void 0:e.ok)&&"sections"in t.responseData.body){let e=t.responseData.body.sections;(null===(n=null===(r=t.extraResponseData)||void 0===r?void 0:r.body)||void 0===n?void 0:n.sections)&&(e=Object.assign(Object.assign({},e),t.extraResponseData.body.sections));for(let r in e)e[r]?document.querySelectorAll(`#shopify-section-${r}`).forEach((n=>{let u=[];const l="__noId__",d={};n.querySelectorAll(` [${i}] `).forEach((t=>{let e=t.getAttribute(i).toString().trim();""===e&&(e=l),e in d||(d[e]=[]),d[e].push({scroll:t.scrollTop,height:t.scrollHeight})}));const p={},f=n.querySelectorAll(`[${o}]`);f&&f.forEach((t=>{let e=t.getAttribute(o).toString().trim();""===e&&(e=l),e in p||(p[e]=[]),p[e].push(t)}));const m=n.querySelectorAll(`[${a}]`);if(m){const t=s.parseFromString(e[r],"text/html");for(let e in p)t.querySelectorAll(` [${o}="${e.replace(l,"")}"] `).forEach(((t,r)=>{r+1<=p[e].length&&(console.log(e),t.before(p[e][r]),t.parentElement.removeChild(t))}));const i=t.querySelectorAll(`[${a}]`);if(m.length!==i.length){console.error(`Liquid Ajax Cart: the received HTML for the "${r}" section has a different quantity of the "${a}" containers. The section will be updated completely.`);const e=t.querySelector(`#shopify-section-${r}`);if(e){for(n.innerHTML="";e.childNodes.length;)n.appendChild(e.firstChild);u.push(n)}}else m.forEach(((t,e)=>{t.before(i[e]),t.parentElement.removeChild(t),u.push(i[e])}))}for(let e in d)n.querySelectorAll(` [${i}="${e.replace(l,"")}"] `).forEach(((r,o)=>{o+1<=d[e].length&&("add"!==t.requestType||d[e][o].height>=r.scrollHeight)&&(r.scrollTop=d[e][o].scroll)}));u.length>0&&c.push({id:r,elements:u})})):console.error(`Liquid Ajax Cart: the HTML for the "${r}" section was requested but the response is ${e[r]}`)}c.length>0&&w.length>0&&w.forEach((t=>{try{t(c)}catch(t){console.error("Liquid Ajax Cart: Error during a call of a sections update subscriber"),console.error(t)}}))}))})),function(){d(((t,e)=>{m=void 0,p++,g(),e((t=>{!function(t){var e,r;let o;m=void 0,p--,(null===(e=t.extraResponseData)||void 0===e?void 0:e.ok)&&(o=b(t.extraResponseData.body)),!o&&(null===(r=t.responseData)||void 0===r?void 0:r.ok)&&("add"===t.requestType?u():o=b(t.responseData.body)),o?(m=y,y=o):null===o&&console.error("Liquid Ajax Cart: expected to receive the updated cart state but the object is not recognized. The request state:",t)}(t),g()}))}));const t=document.querySelector(`[${v.computed.initialStateAttribute}]`);if(t)try{const e=JSON.parse(t.textContent);if(y=b(e),null===y)throw`JSON from ${v.computed.initialStateAttribute} script is not correct cart object`;g()}catch(t){console.error(`Liquid Ajax Cart: can't parse cart JSON from the "${v.computed.initialStateAttribute}" script. A /cart.js request will be performed to receive the cart state`),console.error(t),i()}else i()}(),q(C),C(A()),document.addEventListener("click",(function(t){for(let e=t.target;e&&e!=document.documentElement;e=e.parentElement)$(e,t)}),!1),document.addEventListener("change",(function(t){I(t.target,t)}),!1),document.addEventListener("keydown",(function(t){const e=t.target;"Enter"===t.key&&(e instanceof HTMLTextAreaElement&&!t.ctrlKey||I(e,t)),"Escape"===t.key&&function(t){if(!R(t))return;if(!(t instanceof HTMLInputElement||t instanceof HTMLTextAreaElement))return;if(t instanceof HTMLInputElement&&("checkbox"===t.type||"radio"===t.type))return;const e=A();if(!e.status.cartStateSet)return void t.blur();const{objectCode:r,propertyName:o}=N(t);if(!r)return;let n;if("note"===r)n=e.cart.note;else if("attributes"===r)n=e.cart.attributes[o];else{const[t]=E(r,e);t&&(n=t.properties[o])}void 0!==n&&(n||"string"==typeof n||n instanceof String||(n=""),t.value=String(n)),t.blur()}(e)}),!1),q(F),F(A()),document.addEventListener("change",(function(t){B(t.target,t)}),!1),document.addEventListener("keydown",(function(t){"Enter"===t.key&&B(t.target,t),"Escape"===t.key&&function(t){const{quantityInputAttribute:e}=v.computed;if(!T(t))return;const r=t.getAttribute(e).trim();let o;const n=A();if(n.status.cartStateSet){if(r.length>3)o=n.cart.items.find((t=>t.key===r));else{const t=Number(r)-1;o=n.cart.items[t]}o&&(t.value=o.quantity.toString())}t.blur()}(t.target)}),!1),q(k),k(A()),document.addEventListener("click",(function(t){for(let e=t.target;e&&e!=document.documentElement;e=e.parentElement)O(e,t)}),!1),q(J),J(A()),d(((t,e)=>{"add"===t.requestType&&e((t=>{var e;if(null===(e=t.responseData)||void 0===e?void 0:e.ok){const{addToCartCssClass:t}=v;let e="",r=0;if("string"==typeof t||t instanceof String?e=t:Array.isArray(t)&&2===t.length&&("string"==typeof t[0]||t[0]instanceof String)&&("number"==typeof t[1]||t[1]instanceof Number)?(e=t[0],t[1]>0?r=t[1]:console.error(`Liquid Ajax Cart: the addToCartCssClass[1] value must be a positive integer. Now it is ${t[1]}`)):console.error('Liquid Ajax Cart: the "addToCartCssClass" configuration parameter must be a string or a [string, number] array'),""!==e){try{document.body.classList.add(e)}catch(t){console.error(`Liquid Ajax Cart: error while adding the "${e}" CSS class from the addToCartCssClass parameter to the body tag`),console.error(t)}r>0&&(void 0!==W&&clearTimeout(W),W=setTimeout((()=>{document.body.classList.remove(e)}),r))}}}))})),d(((t,e)=>{const r={};r.add=U,r.change=M,t.requestType in r&&r[t.requestType](t,e)})),window.liquidAjaxCart={configureCart:L,cartRequestGet:i,cartRequestAdd:s,cartRequestChange:c,cartRequestUpdate:u,cartRequestClear:l,subscribeToCartAjaxRequests:d,getCartState:A,subscribeToCartStateUpdate:q,subscribeToCartSectionsUpdate:function(t){w.push(t)}},window.addEventListener("focus",(()=>{v.updateOnWindowFocus&&u({},{})})));const G=window.liquidAjaxCart.configureCart,Q=window.liquidAjaxCart.cartRequestGet,V=window.liquidAjaxCart.cartRequestAdd,K=window.liquidAjaxCart.cartRequestChange,z=window.liquidAjaxCart.cartRequestUpdate,X=window.liquidAjaxCart.cartRequestClear,Y=window.liquidAjaxCart.subscribeToCartAjaxRequests,Z=window.liquidAjaxCart.getCartState,tt=window.liquidAjaxCart.subscribeToCartStateUpdate,et=window.liquidAjaxCart.subscribeToCartSectionsUpdate;var rt=e.x$,ot=e.nd,nt=e.yF,at=e.fi,it=e.Be,st=e.ih,ct=e.KJ,ut=e.Q4,lt=e.WP,dt=e.w0;export{rt as cartRequestAdd,ot as cartRequestChange,nt as cartRequestClear,at as cartRequestGet,it as cartRequestUpdate,st as configureCart,ct as getCartState,ut as subscribeToCartAjaxRequests,lt as subscribeToCartSectionsUpdate,dt as subscribeToCartStateUpdate};
</script>