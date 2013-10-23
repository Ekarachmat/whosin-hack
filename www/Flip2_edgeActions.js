
(function($,Edge,compId){var Composition=Edge.Composition,Symbol=Edge.Symbol;
//Edge symbol: 'stage'
(function(symbolName){Symbol.bindTriggerAction(compId,symbolName,"Default Timeline",0,function(sym,e){});
//Edge binding end
Symbol.bindTriggerAction(compId,symbolName,"Default Timeline",10000,function(sym,e){sym.play(0);});
//Edge binding end
})("stage");
//Edge symbol end:'stage'

//=========================================================

//Edge symbol: 'Flapper'
(function(symbolName){Symbol.bindSymbolAction(compId,symbolName,"creationComplete",function(sym,e){});
//Edge binding end
Symbol.bindTriggerAction(compId,symbolName,"Default Timeline",100,function(sym,e){});
//Edge binding end
})("characterFlapper");
//Edge symbol end:'characterFlapper'

//=========================================================

//Edge symbol: 'Line1'
(function(symbolName){Symbol.bindTriggerAction(compId,symbolName,"Default Timeline",0,function(sym,e){});
//Edge binding end
})("Line1");
//Edge symbol end:'Line1'

//=========================================================

//Edge symbol: 'blueDot'
(function(symbolName){})("blueDot");
//Edge symbol end:'blueDot'

//=========================================================

//Edge symbol: 'blueDotAnimation'
(function(symbolName){Symbol.bindTriggerAction(compId,symbolName,"Default Timeline",1000,function(sym,e){sym.play(0);});
//Edge binding end
})("blueDotAnimation");
//Edge symbol end:'blueDotAnimation'

//=========================================================

//Edge symbol: 'loadingAnimation'
(function(symbolName){Symbol.bindTriggerAction(compId,symbolName,"Default Timeline",10000,function(sym,e){sym.play(0);});
//Edge binding end
})("loadingAnimation");
//Edge symbol end:'loadingAnimation'

//=========================================================

//Edge symbol: 'beam'
(function(symbolName){Symbol.bindTriggerAction(compId,symbolName,"Default Timeline",5000,function(sym,e){sym.play(0);});
//Edge binding end
})("beam");
//Edge symbol end:'beam'

//=========================================================

//Edge symbol: 'time'
(function(symbolName){Symbol.bindTriggerAction(compId,symbolName,"Default Timeline",0,function(sym,e){var currentdate=new Date();var datetime=""+("0"+currentdate.getDate()).substring(currentdate.getDate()>9?1:0)+" / "
+("0"+currentdate.getMonth()).substring(currentdate.getMonth()>9?1:0)+" / "
+currentdate.getFullYear()+"  "
+("0"+currentdate.getHours()).substring(currentdate.getHours()>9?1:0)+" : "
+("0"+currentdate.getMinutes()).substring(currentdate.getMinutes()>9?1:0)+" : "
+("0"+currentdate.getSeconds()).substring(currentdate.getSeconds()>9?1:0);sym.$("time").html(datetime);});
//Edge binding end
Symbol.bindTriggerAction(compId,symbolName,"Default Timeline",1000,function(sym,e){sym.play(0);});
//Edge binding end
})("time");
//Edge symbol end:'time'

//=========================================================

//Edge symbol: 'clockFlap'
(function(symbolName){})("clockFlap");
//Edge symbol end:'clockFlap'
})(jQuery,AdobeEdge,"EDGE-3123259");