<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="100%">
	<style type="text/css">
	<![CDATA[
		 image.warning {
			-webkit-animation-duration: 0.5s;
			-webkit-animation-iteration-count: infinite;
			-webkit-animation-timing-function: ease-in-out;
			-webkit-animation-direction: alternate;
			-webkit-animation-name: blink;
		}
		@-webkit-keyframes blink {
			0% { opacity: 0; }
			100% { opacity: 1; }
		}
	]]>
    </style>
	<g>
		<image 
					xlink:href="<?php echo $bgImgDataUri; ?>" 
					width="<?php echo $bgImageWidth; ?>" 
					height="<?php echo $bgImageHeight; ?>" />
		<image class="warning" 
					xlink:href="<?php echo $statusImgDataUri; ?>" 
					width="<?php echo $statusImageWidth; ?>" 
					height="<?php echo $statusImageHeight; ?>" 
					x="<?php echo ($bgImageWidth - $statusImageWidth); ?>" 
					y="<?php echo ($bgImageHeight - $statusImageHeight); ?>" />
	</g>
</svg>