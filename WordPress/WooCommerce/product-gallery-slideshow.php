<!-- 
    *
    * CSS
    *
-->
<style>
.mySlides {display: none}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  bottom: -50px;
  width: auto;
  padding: 16px;
  color: var(--black);
  font-weight: bold;
  font-size: 18px;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  opacity: 0.8;
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: var(--black);
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active, .dot:hover {
  background-color: var(--green);
  border: 2px solid var(--black);
}

/* Fading animation */
.fade {
  animation-name: fade;
  animation-duration: 1.5s;
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .prev, .next,.text { font-size: 11px; }
}
</style>



<!-- 
    *
    * HTML
    *
 -->
<div class="slideshow-container">
    <?php
    global $product;
    $attachment_ids = $product->get_gallery_attachment_ids();

    foreach( $attachment_ids as $attachment_id ) { ?>
        <div class="mySlides fade">
            <img src="<?php echo $medium_url = wp_get_attachment_image_src( $attachment_id, '1000' )[0]; ?>" />
        </div>
    <?php } ?>

    <a class="prev" onclick="plusSlides(-1)">❮</a>
    <a class="next" onclick="plusSlides(1)">❯</a>

</div>
<br />
<div style="text-align:center">
    <?php
    $slidecounter = 1;
    foreach( $attachment_ids as $attachment_id ) { ?>
    <span class="dot" onclick="//currentSlide(1)"></span>
    <?php } ?>
</div>



<!-- 
    *
    * JAVASCRIPT 
    *
-->
<script>
	let slideIndex = 1;
	showSlides(slideIndex);

	function plusSlides(n) {
		showSlides(slideIndex += n);
	}

	function currentSlide(n) {
		showSlides(slideIndex = n);
	}

	function showSlides(n) {
		let i;
		let slides = document.getElementsByClassName("mySlides");
		let dots = document.getElementsByClassName("dot");
		if (n > slides.length) {slideIndex = 1}    
		if (n < 1) {slideIndex = slides.length}
		for (i = 0; i < slides.length; i++) {
			slides[i].style.display = "none";  
		}
		for (i = 0; i < dots.length; i++) {
			dots[i].className = dots[i].className.replace(" active", "");
		}
		slides[slideIndex-1].style.display = "block";  
		dots[slideIndex-1].className += " active";
	}
</script>