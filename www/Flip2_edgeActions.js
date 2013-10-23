
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
})(jQuery,AdobeEdge,"EDGE-3123259");