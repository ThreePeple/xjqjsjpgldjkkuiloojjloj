<?php

use yii\helpers\Url;
use app\models\ViewTemplate;

$this->registerCssFile('/css/popuppanel.css'); 
$this->registerCssFile('/css/style.css');
$this->registerCssFile('/css/building-editor.css',['depends'=>'frontend\assets\AppAsset']);


$this->registerJsFile('/js/popuppanel.js',['depends'=>'frontend\assets\AppAsset']);
$this->registerJsFile('/js/topology_wlan.js',['depends'=>'frontend\assets\AppAsset']); 
$this->registerJsFile('/js/d3.min.js',['depends'=>'frontend\assets\AppAsset']);

?>
<style>
	.wire-network{
		position: relative;
	}
	.wire-network a{
		-webkit-transform: rotate(62deg) translate(129px, -159px); 
		position: absolute;
		left: 0;
		top: 0;
		width: 123px;
		height: 48px; 
		z-index: 2;
	}

	.wire-network a[data-area-id="a"]{
		-webkit-transform: translate(103px, 137px);
	}

	.wire-network a[data-area-id="b"]{
		  -webkit-transform: translate(1036px, 175px);
	}

	.wire-network a[data-area-id="c"]{
	  -webkit-transform: translate(1180px, 270px);
	  width: 186px;
	}

	.wire-network a[data-area-id="d"]{
	  -webkit-transform: translate(1247px, 572px);
	  width: 200px;
	}

	.wire-network a[data-area-id="e"]{
		  -webkit-transform: translate(1226px, 866px);
	}

	.wire-network a[data-area-id="f"]{
  -webkit-transform: translate(125px, 661px);
	}
	.buidling-editor-container text.title{
		display: none;
	}
	
	svg.ZSYFCEditor path.node_link_error{
		stroke: red !important;
	}

	.nodeDetail .popupBody ul{
	    margin: 0 10px;
	    padding: 0;
	}	
	.nodeDetail .popupBody li {
		color: #ababab;
		margin: 3px 0;
		white-space: nowrap;
		list-style: none;
	}
	.nodeDetail .popupBody li span{
		font-weight: bold;
		margin-right: 10px;
		color: #fff;
	}
	.nodeDetail .popup_content{
	    max-height: 350px;
	    min-width: 330px;
	    overflow: auto;
	} 	

	.wire-network{
		background:url(/images/wlan/bg.png) no-repeat;
		position: relative;
	}
	.wire-network svg g.element_link{
		cursor: pointer;
	}
	.wire-network svg g.element_link path{
		stroke: #3cdc78; 
		stroke-linecap: round;
		stroke-width: 1.4px;
		fill: none;
	}
	.wire-network svg g.element_link path:hover{
		stroke: #E4FCED;
	}
	.wire-network svg g.element_link[data-status="2"] path{
		stroke: red !important;
	}
	.wire-network svg g.element_link[data-status="2"] path{
		stroke: rgb(255, 100, 100) !important;
	}
	.wire-network .element_node {
	    position: absolute;
	    cursor: pointer;
	}
	.wire-network .element_node .switch{
		background:url(/images/wlan/switch.png) no-repeat;
		width:54px;
		height:41px;
	}
	.wire-network .element_node[data-status="2"] .switch{
		background:url(/images/wlan/alarm/switch.gif) no-repeat;
	}

	.wire-network .element_node .server{
		background:url(/images/wlan/server.png) no-repeat;
		width:43px;
		height:60px;
	}
	.wire-network .element_node[data-status="2"] .server{
		background: url(/images/wlan/alarm/server.gif) no-repeat;
	}

	.wire-network .element_node .router{
		background:url(/images/wlan/router.png) no-repeat;
		width:38px;
		height:38px;
	}
	
	.wire-network .element_node[data-status="2"] .router{
		background:url(/images/wlan/alarm/router.gif) no-repeat;
		height: 42px;
	}

	.wire-network .element_node .firewall{
		background:url(/images/wlan/firewall.png) no-repeat;
		width:46px;
		height:55px;
	}
	.wire-network .element_node[data-status="2"] .firewall{
		background:url(/images/wlan/alarm/firewall.gif) no-repeat; 
	}	

	.wire-network .element_node .mainSwitch{
		background:url(/images/wlan/mainSwitch.png) no-repeat;
		width:64px;
		height:44px;
	}
	.wire-network .element_node[data-status="2"]  .mainSwitch{
		background:url(/images/wlan/alarm/mainSwitch.gif) no-repeat; 
	}

	.wire-network .element_node .core{
		background:url(/images/wlan/core.png) no-repeat;
		width:52px;
		height:38px;
	}
	.wire-network .element_node[data-status="2"] .core{
		background:url(/images/wlan/alarm/core.gif) no-repeat; 
	}	
</style>
<script type="text/single-html-template" id="switch_node_detail">
    <ul> 
        <li><span>名称:</span>{name}</li>
        <li><span>楼层:</span>{floor}</li> 
        <li><span>ip地址:</span>{ip}</li>
        <li><span>设备厂商:</span>{vendors}</li>
        <li><span>设备类型:</span>{deviceType}</li>
    </ul>
</script>
<div class="row">
    <h4 style="color:white">有线网络拓扑</h4>
    <div class="wire-network" id="wireNetworkHolder"> 
		<svg style="width: 1366px; height: 715px;"> 
			<g class="element_link" id="element_line_1">
                 <path d="M 258 160 L 346 116 L 398 146 L 316 186 L 283 191 L 258 174">
			</g>
			<g class="element_link" id="element_line_2">
                 <path d="M 260 161 L 345 120 L 388 146 L 309 184 L 286 185 L 264 170">
			</g>			
			
			<g class="element_link" id="element_line_3">
                 <path d="M 227 153 L 203 137 L 262 107 ">
			</g>
			<g class="element_link" id="element_line_4">
                 <path d="M 285 97 L 327 74 ">
			</g>
			<g class="element_link" id="element_line_5">
                 <path d="M 289 99 L 331 76 ">
			</g>
			<g class="element_link" id="element_line_6">
                 <path d="M 355 80 L 377 95 L 280 143 L 335 179 L 319 190 ">
			</g>
			<g class="element_link" id="element_line_7">
                 <path d="M 253 157 L 275 146 L 336 186 L 446 133 L 472 149 ">
			</g>
			<g class="element_link" id="element_line_8">
                 <path d="M 188 190 L 232 168 ">
			</g>
			<g class="element_link" id="element_line_9">
                 <path d="M 183 205 L 219 230 ">
			</g>
			<g class="element_link" id="element_line_10">
                 <path d="M 246 225 L 295 200 ">
			</g>
			<g class="element_link" id="element_line_11">
                 <path d="M 319 205 L 354 227 L 412 198 ">
			</g>
			<g class="element_link" id="element_line_12">
                 <path d="M 437 187 L 483 163 ">
			</g>
			<g class="element_link" id="element_line_13">
                 <path d="M 442 190 L 486 167 ">
			</g>
			<g class="element_link" id="element_line_14">
                 <path d="M 242 237 L 327 290 L 447 231 L 559 294 ">
			</g>
			<g class="element_link" id="element_line_15">
                 <path d="M 436 202 L 501 238 L 21 479 L 253 644 L 284 629 ">
			</g>
			<g class="element_link" id="element_line_16">
                 <path d="M 508 168 L 575 206 L 31 479 L 202 602 L 225 589 ">
			</g>
			<g class="element_link" id="element_line_17">
                 <path d="M 723 157 L 765 179	">
			</g>
			<g class="element_link" id="element_line_18">
                 <path d="M 720 161 L 764 183">
			</g>
			<g class="element_link" id="element_line_19">
                 <path d="M 771 183 L 684 227 L 803 293 L 690 355">
			</g>
			<g class="element_link" id="element_line_20">
                 <path d="M 824 157 L 795 174">
			</g>
			<g class="element_link" id="element_line_21">
                 <path d="M 853 145 L 894 120">
			</g>
			<g class="element_link" id="element_line_22">
                 <path d="M 789 123 L 814 137">
			</g>
			<g class="element_link" id="element_line_23">
                 <path d="M 785 126 L 810 140">
			</g>
			<g class="element_link" id="element_line_24">
                 <path d="M 783 107 L 824 85">
			</g>
			<g class="element_link" id="element_line_25">
                 <path d="M 728 138 L 757 122 ">
			</g>
			<g class="element_link" id="element_line_26">
                 <path d="M 701 149 L 496 252 L 564 291">
			</g>
			<g class="element_link" id="element_line_27">
                 <path d="M 585 297 L 710 232 L 1002 386 L 1051 357">
			</g>
			<g class="element_link" id="element_line_28">
                 <path d="M 593 298 L 711 238 L 808 290 L 874 251">
			</g>
			<g class="element_link" id="element_line_29">
                 <path d="M 598 302 L 657 270 L 1030 469 L 1010 482">
			</g>
			<g class="element_link" id="element_line_30">
                 <path d="M 603 305 L 627 290 L 889 430">
			</g>
			<g class="element_link" id="element_line_31">
                 <path d="M 563 314 L 494 351 L 689 463 L 321 671 L 281 641 L 295 634">
			</g>
			<g class="element_link" id="element_line_32">
                 <path d="M 571 316 L 510 351 L 878 558 L 910 542">
			</g>
			<g class="element_link" id="element_line_33">
                 <path d="M 575 320 L 525 348 L 807 507 L 825 498">
			</g>
			<g class="element_link" id="element_line_34">
                 <path d="M 671 372 L 603 409 L 699 463 L 320 678 L 220 604 L 236 595">
			</g>
			<g class="element_link" id="element_line_35">
                 <path d="M 675 376 L 620 408 L 880 553 L 905 538">
			</g>
			<g class="element_link" id="element_line_36">
                 <path d="M 679 379 L 635 406 L 806 500 L 819 493">
			</g>
			<g class="element_link" id="element_line_37">
                 <path d="M 697 356 L 720 344 L 883 434">
			</g>
			<g class="element_link" id="element_line_38">
                 <path d="M 702 361 L 759 329 L 1017 469 L 1001 477">
			</g>
			<g class="element_link" id="element_line_39">
                 <path d="M 700 380 L 758 411 L 887 333 L 1071 430 L 1129 396">
			</g>
			<g class="element_link" id="element_line_40">
                 <path d="M 708 375 L 759 401 L 945 288">
			</g>	

			<g class="element_link" id="element_line_41">
                 <path d="M 901 236 L 941 211">
			</g>
			<g class="element_link" id="element_line_42">
                 <path d="M 962 202 L 1004 175">
			</g>
			<g class="element_link" id="element_line_43">
                 <path d="M 907 241 L 928 228 L 987 256 L 1003 246">
			</g>
			<g class="element_link" id="element_line_44">
                 <path d="M 944 216 L 935 223 L 987 248 L 960 266">
			</g>
			<g class="element_link" id="element_line_45">
                 <path d="M 907 257 L 932 270">
			</g>
			<g class="element_link" id="element_line_46">
                 <path d="M 911 253 L 937 267">
			</g>
			<g class="element_link" id="element_line_47">
                 <path d="M 971 272 L 1006 249">
			</g>
			<g class="element_link" id="element_line_48">
                 <path d="M 1030 237 L 1075 210">
			</g>
			<g class="element_link" id="element_line_49">
                 <path d="M 1208 259 L 1182 278">
			</g>
			<g class="element_link" id="element_line_50">
                 <path d="M 1276 294 L 1251 312">
			</g>
			<g class="element_link" id="element_line_51">
                 <path d="M 1161 289 L 1121 312">
			</g>
			<g class="element_link" id="element_line_52">
                 <path d="M 1166 292 L 1156 300 L 1207 324 L 1180 342">
			</g>
			<g class="element_link" id="element_line_53">
                 <path d="M 1128 317 L 1149 306 L 1209 331 L 1223 321">
			</g>
			<g class="element_link" id="element_line_54">
                 <path d="M 1194 348 L 1227 326">
			</g>
			<g class="element_link" id="element_line_55">
                 <path d="M 1128 334 L 1153 346">
			</g>
			<g class="element_link" id="element_line_56">
                 <path d="M 1134 329 L 1159 343">
			</g>
			<g class="element_link" id="element_line_57">
                 <path d="M 1072 369 L 1114 388">
			</g>
			<g class="element_link" id="element_line_58">
                 <path d="M 1077 365 L 1115 382">		
			</g>
			<g class="element_link" id="element_line_59">
                 <path d=" M 1149 381 L 1171 364">
			</g>
			<g class="element_link" id="element_line_60">
                 <path d="M 968 477 L 930 454">
			</g>
			<g class="element_link" id="element_line_61">
                 <path d="M 981 496 L 933 526">
			</g>
			<g class="element_link" id="element_line_62">
                 <path d="M 900 451 L 848 483">
			</g>
			<g class="element_link" id="element_line_63">
                 <path d="M 852 499 L 895 523">
			</g>
	
			<g class="element_link" id="element_line_64">
                 <path d="M 268 446 L 218 414 L 90 476 L 99 486">
			</g>
			<g class="element_link" id="element_line_65">
                 <path d="M 128 489 L 156 471">
			</g>
			<g class="element_link" id="element_line_66">
                 <path d="M 216 509 L 188 526">
			</g>
			<g class="element_link" id="element_line_67">
                 <path d="M 133 503 L 155 517">
			</g>
			<g class="element_link" id="element_line_68">
                 <path d="M 148 521 L 128 507">
			</g>
			<g class="element_link" id="element_line_68">
                 <path d="M 104 502 L 87 512 L 266 643 L 288 631">
			</g>
			<g class="element_link" id="element_line_70">
                 <path d="M 162 536 L 142 548 L 215 599 L 228 593">
			</g>
			<g class="element_link" id="element_line_71">
                 <path d="M 254 578 L 281 561">
			</g>
			<g class="element_link" id="element_line_72">
                 <path d="M 247 600 L 275 620">
			</g>
			<g class="element_link" id="element_line_73">
                 <path d="M 252 598 L 277 614">
			</g>
			<g class="element_link" id="element_line_74">
                 <path d="M 314 617 L 342 601">
			</g>
			<g class="element_link" id="element_line_75">
                 <path d="M 298 567 L 337 592">
			</g>
			<g class="element_link" id="element_line_76">
                 <path d="M 304 563 L 340 587">
			</g>
			<g class="element_link" id="element_line_77">
                 <path d="M 307 548 L 341 528">
			</g>
			<g class="element_link" id="element_line_78">
                 <path d="M 368 587 L 404 568">
			</g>
			<g class="element_link" id="element_line_79">
                 <path d="M 363 518 L 399 497">
			</g>
			<g class="element_link" id="element_line_80">
                 <path d="M 426 555 L 461 536">
			</g>
			<g class="element_link" id="element_line_81">
                 <path d="M 416 507 L 448 529">
			</g>

			<g class="element_link" id="element_line_82">
                 <path d="M 422 504 L 450 522">
			</g>
			<g class="element_link" id="element_line_83">
                 <path d="M 424 485 L 453 465">
			</g>
			<g class="element_link" id="element_line_84">
                 <path d="M 485 523 L 519 504">
			</g>
			<g class="element_link" id="element_line_85">
                 <path d="M 471 470 L 512 497">
			</g>
			<g class="element_link" id="element_line_86">
                 <path d="M 477 464 L 512 490">
			</g>
			<g class="element_link" id="element_line_87">
                 <path d="M 477 453 L 506 437">
			</g>
			<g class="element_link" id="element_line_88">
                 <path d="M 542 494 L 574 475">
			</g>
			<g class="element_link" id="element_line_89">
                 <path d="M 511 441 L 504 447 L 554 476 L 540 485">
			</g>
			<g class="element_link" id="element_line_90">
                 <path d="M 479 460 L 497 450 L 554 481 L 568 473 ">
			</g>
		</svg>
        <div id="element_node_1" class="element_node" style="top:140px;left:216px;">
            <div class="switch"></div>
        </div>
        <div id="element_node_2" class="element_node" style="top:79px;left:245px;">
            <div class="switch"></div>
        </div>
        <div id="element_node_3" class="element_node" style="top:48px;left:312px;">
            <div class="switch"></div>
        </div>
        <div id="element_node_4" class="element_node" style="top:172px;left:279px;">
            <div class="switch"></div>
        </div>
        <div id="element_node_5" class="element_node" style="top:169px;left:395px;">
            <div class="switch"></div>
        </div>
        <div id="element_node_6" class="element_node" style="top:134px;left:466px;">
            <div class="switch"></div>
        </div>
        <div id="element_node_7" class="element_node" style="top:473px;left:85px;">
            <div class="switch"></div>
        </div>
        <div id="element_node_8" class="element_node" style="top:505px;left:145px;">
            <div class="switch"></div>
        </div>
        <div id="element_node_9" class="element_node" style="top:501px;left:324px;">
            <div class="switch"></div>
        </div>
        <div id="element_node_11" class="element_node" style="top:536px;left:385px;">
            <div class="switch"></div>
        </div>
        <div id="element_node_12" class="element_node" style="top:410px;left:490px;">
            <div class="switch"></div>
        </div>
        <div id="element_node_13" class="element_node" style="top:445px;left:554px;">
            <div class="switch"></div>
        </div>
        <div id="element_node_14" class="element_node" style="top:187px;left:927px;">
            <div class="switch"></div>
        </div>
        <div id="element_node_15" class="element_node" style="top:218px;left:985px;">
            <div class="switch"></div>
        </div>
        <div id="element_node_16" class="element_node" style="top:264px;left:1146px;">
            <div class="switch"></div>
        </div>
        <div id="element_node_17" class="element_node" style="top:293px;left:1205px;">
            <div class="switch"></div>
        </div><!-- server -->
        <div id="element_node_18" class="element_node" style="top:410px;left:256px;">
            <div class="server"></div>
        </div>
        <div id="element_node_19" class="element_node" style="top:32px;left:806px;">
            <div class="server"></div>
        </div>
        <div id="element_node_20" class="element_node" style="top:68px;left:876px;">
            <div class="server"></div>
        </div>
        <div id="element_node_21" class="element_node" style="top:122px;left:987px;">
            <div class="server"></div>
        </div>
        <div id="element_node_22" class="element_node" style="top:156px;left:1057px;">
            <div class="server"></div>
        </div>
        <div id="element_node_23" class="element_node" style="top:207px;left:1190px;">
            <div class="server"></div>
        </div>
        <div id="element_node_24" class="element_node" style="top:246px;left:1261px;">
            <div class="server"></div>
        </div><!-- router -->
        <div id="element_node_25" class="element_node" style="top:439px;left:140px;">
            <div class="router"></div>
        </div>
        <div id="element_node_26" class="element_node" style="top:473px;left:201px;">
            <div class="router"></div>
        </div>
        <div id="element_node_27" class="element_node" style="top:530px;left:274px;">
            <div class="router"></div>
        </div>
        <div id="element_node_28" class="element_node" style="top:565px;left:335px;">
            <div class="router"></div>
        </div>
        <div id="element_node_29" class="element_node" style="top:433px;left:444px;">
            <div class="router"></div>
        </div>
        <div id="element_node_30" class="element_node" style="top:467px;left:508px;">
            <div class="router"></div>
        </div>
        <div id="element_node_31" class="element_node" style="top:170px;left:165px;">
            <div class="router"></div>
        </div>
        <div id="element_node_32" class="element_node" style="top:201px;left:213px;">
            <div class="router"></div>
        </div><!-- firewall -->
        <div id="element_node_33" class="element_node" style="top:546px;left:208px;">
            <div class="firewall"></div>
        </div>
        <div id="element_node_34" class="element_node" style="top:583px;left:266px;">
            <div class="firewall"></div>
        </div>
        <div id="element_node_35" class="element_node" style="top:451px;left:378px;">
            <div class="firewall"></div>
        </div>
        <div id="element_node_36" class="element_node" style="top:487px;left:439px;">
            <div class="firewall"></div>
        </div>
        <div id="element_node_37" class="element_node" style="top:104px;left:681px;">
            <div class="firewall"></div>
        </div>
        <div id="element_node_38" class="element_node" style="top:142px;left:753px;">
            <div class="firewall"></div>
        </div>
        <div id="element_node_39" class="element_node" style="top:318px;left:1033px;">
            <div class="firewall"></div>
        </div>
        <div id="element_node_40" class="element_node" style="top:350px;left:1102px;">
            <div class="firewall"></div>
        </div> 
        <div id="element_node_41" class="element_node" style="top:287px;left:553px;">
            <div class="core"></div>
        </div>
        <div id="element_node_42" class="element_node" style="top:347px;left:658px;">
            <div class="core"></div>
        </div>
        <div id="element_node_43" class="element_node" style="top:462px;left:798px;">
            <div class="mainSwitch"></div>
        </div>
        <div id="element_node_44" class="element_node" style="top:504px;left:882px;">
            <div class="mainSwitch"></div>
        </div>
        <div id="element_node_45" class="element_node" style="top:418px;left:873px;">
            <div class="mainSwitch"></div>
        </div>
        <div id="element_node_46" class="element_node" style="top:458px;left:951px;">
            <div class="mainSwitch"></div>
        </div>
        <div id="element_node_47" class="element_node" style="top:89px;left:730px;">
            <div class="mainSwitch"></div>
        </div>
        <div id="element_node_48" class="element_node" style="top:122px;left:796px;">
            <div class="mainSwitch"></div>
        </div>
        <div id="element_node_49" class="element_node" style="top:221px;left:853px;">
            <div class="mainSwitch"></div>
        </div>
        <div id="element_node_50" class="element_node" style="top:252px;left:918px;">
            <div class="mainSwitch"></div>
        </div>
        <div id="element_node_51" class="element_node" style="top:297px;left:1076px;">
            <div class="mainSwitch"></div>
        </div>
        <div id="element_node_52" class="element_node" style="top:328px;left:1140px;">
            <div class="mainSwitch"></div>
        </div> 
    </div>
</div>