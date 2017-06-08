//Slide banner by kangk @2010-01-07
$(document).ready(function(){
	var domObj = $("#flashBox ul li");
	var domNum = $("#flashBox ul li").size();
	var i=0;
	var btStr="";
	
	for(k=1;k<=domNum;k++){
		btStr = btStr + "<span>"+k+"</span>";
	}
	$("#flashBox .btSlide").html(btStr);
	
	
	function slide(){
		if(i>domNum-1){i=0;}
		if($("#flashBox ul #slideShow").length>0){
			$("#flashBox ul #slideShow").animate({left:"-637px"},500,function(){$(this).css("left","637px");});
			domObj.eq(i).animate({left:"0px"},500);
			domObj.attr("id","");
			domObj.eq(i).attr("id","slideShow");
			$("#flashBox .btSlide span").css("color","#ccc")
			$("#flashBox .btSlide span").eq(i).css("color","#f60")
			i++;
		}else{
			domObj.eq(0).animate({left:"0px"},500);
			domObj.eq(0).attr("id","slideShow");
			$("#flashBox .btSlide span").css("color","#ccc")
			$("#flashBox .btSlide span").eq(0).css("color","#f60")
			i=1;
		}
	}
	
	slide();
	
	var sss;
	function slideStart(){
		sss = setInterval(slide,4000);
	}
	function slideEnd(){
		clearInterval(sss);
		sss = null;
	}
	slideStart();
	
	$("#flashBox .btSlide span").click(function(){
		slideEnd();
		i = parseFloat($(this).text())-1;
		slide();
		slideStart();
	});
});


function checkdomain(){
			var str = $.trim($("#domainInput").val());
			$("#domainInput").val(str.replace(/[^0-9A-Za-z\-]+/g,""));
			
			}



// 这里都是公用函数
var
// 获取元素
/*
$ = function(element) {
	return (typeof(element) == 'object' ? element : document.getElementById(element));
},*/
// 判断浏览器
brower = function() {
	var ua = navigator.userAgent.toLowerCase();
	var os = new Object();
	os.isFirefox = ua.indexOf ('gecko') != -1;
	os.isOpera = ua.indexOf ('opera') != -1;
	os.isIE = !os.isOpera && ua.indexOf ('msie') != -1;
	os.isIE7 = os.isIE && ua.indexOf ('7.0') != -1;
	return os;
},
// 获取鼠标位置
getXY = function (e) {
	var XY;
	if(brower().isIE) {
		//XY = new Array(event.clientX, event.clientY);
		var scrollPos;
		if (typeof window.pageYOffset != 'undefined') {
		   scrollPos = {x : window.pageXOffset, y : window.pageYOffset};
		}else if(typeof document.compatMode != 'undefined' && document.compatMode != 'BackCompat') {
		   scrollPos = {x : document.documentElement.scrollLeft, y : document.documentElement.scrollTop};
		}else if(typeof document.body != 'undefined') {
		   scrollPos = {x : document.body.scrollLeft, y : document.body.scrollTop};
		}
		XY = {
			x : window.event.clientX + scrollPos.x - document.body.clientLeft,
			y : window.event.clientY + scrollPos.y - document.body.clientTop
		};
	}else{
		XY = {x: e.pageX, y: e.pageY};
	}
	return XY;
},
// 获取元素坐标
getCoords = function(node){
	var x = node.offsetLeft;
	var y = node.offsetTop;
	var parent = node.offsetParent;
	while (parent != null){
		x += parent.offsetLeft;
		y += parent.offsetTop;
		parent = parent.offsetParent;
	}
	return {x: x, y: y};
},
EndEvent = function(e) {
	e = e || window.event;
	e.stopPropagation && (e.preventDefault(), e.stopPropagation()) || (e.cancelBubble = true, e.returnValue = false);
},
// 事件操作(可保留原有事件)
eventListeners = [],
findEventListener = function(node, event, handler){
	var i;
	for (i in eventListeners){
		if (eventListeners[i].node == node && eventListeners[i].event == event && eventListeners[i].handler == handler){
			return i;
		}
	}
	return null;
},
myAddEventListener = function(node, event, handler){
	if (findEventListener(node, event, handler) != null){
		return;
	}
	if (!node.addEventListener){
		node.attachEvent('on' + event, handler);
	}else{
		node.addEventListener(event, handler, false);
	}
	eventListeners.push({node: node, event: event, handler: handler});
},
removeEventListenerIndex = function(index){
	var eventListener = eventListeners[index];
	delete eventListeners[index];
	if (!eventListener.node.removeEventListener){
		eventListener.node.detachEvent('on' + eventListener.event,
		eventListener.handler);
	}else{
		eventListener.node.removeEventListener(eventListener.event,
		eventListener.handler, false);
	}
},
myRemoveEventListener = function(node, event, handler){
	var index = findEventListener(node, event, handler);
	if (index == null) return;
	removeEventListenerIndex(index);
},
cleanupEventListeners = function(){
	var i;
	for (i = eventListeners.length; i > 0; i--){
		if (eventListeners[i] != undefined){
			removeEventListenerIndex(i);
		}
	}
};


/*======================================================
	- mScrollBox 鼠标控制滚动
	- By Mudoo 2008.6
======================================================*/
function mScrollBox(inits) {
	var _o = this;
	var _i = inits;
	
	// 初始化
	_o.init = function() {
		_o.objFro = document.getElementById(inits.object); //$(inits.object);
		if(_o.objFro == null) {
			alert('初始化失败。');
			return;
		}
		_o.mode		= 'x';		// 滚动模式(x:横向, y:纵向)
		_o.maxSpeed = _i.maxSpeed==undefined ? 7 : _i.maxSpeed;	// 最大滚动步长
		
		_o.width	= _o.objFro.offsetWidth;				// 可见宽度
		_o.sWidth	= _o.objFro.scrollWidth;				// 实际宽度
		_o.smWidth	= _o.sWidth-_o.width;					// 可滚动宽度
		if(_o.smWidth<=0) return;
		
		_o.preSpace = _o.space/_o.width;
		_o.doTimer	= null;
		_o.pos = getCoords(_o.objFro);
		myAddEventListener(_o.objFro, 'mousemove', _o.doScroll);
		myAddEventListener(_o.objFro, 'mouseout', _o.stopScroll);
	}
	
	// 滚动...
	_o.doScroll = function(e) {
		e = e || event;
		var _pos= getXY(e);
		// 计算滚动步长
		_o.speed	= _o.mode=='y' ? (_pos.y-_o.pos.y)/_o.height : (_pos.x-_o.pos.x)/_o.width;
		_o.speed	= (_o.speed-0.5) * 2;
		_o.speed	= Math.round(_o.speed*_o.maxSpeed);
		
		if(_o.doTimer==null) _o.doTimer = setInterval(_o.scrollX, 10);
	}
	
	// 水平滚动
	_o.scrollX = function() {
		_o.objFro.scrollLeft += _o.speed;
		var _left = _o.objFro.scrollLeft;
		if(_left==0 || _left==_o.smWidth) _o.stopScroll();
	}
	
	// 停止滚动
	_o.stopScroll = function() {
		clearInterval(_o.doTimer);
		_o.doTimer = null;
	}
	
	_o.init();
}
/*=============================================
	mScrollBox 测试
=============================================*/
function testMSB() {
	new mScrollBox({object	: 'testMSB2'});
}
myAddEventListener(window, 'load', testMSB);