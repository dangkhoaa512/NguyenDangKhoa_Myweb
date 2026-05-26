arrForEach(theArray, callbackfn, thisArg) {
    if (theArray) {
        var len = theArray[LENGTH] >>> 0;
        for (var idx = 0; idx < len; idx++) {
            if (idx in theArray) {
                if (callbackfn.call(thisArg || theArray, theArray[idx], idx, theArray) === -1) {
                    break;
                }
            }
        }
    }
}

var arrIndexOf = _unwrapFunction(INDEX_OF, ArrProto);
var arrLastIndexOf = _unwrapFunction(LAST_INDEX_OF, ArrProto);

var arrMap = _unwrapFunction("map", ArrProto);

var arrSlice = _unwrapFunction(SLICE, ArrProto);

var fnCall = _unwrapInstFunction("call");

function polyIsArray(value) {
    if (isNullOrUndefined(value)) {
        return false;
    }
    return objToString(value) === "[object Array]";
}
function polyArrIncludes(theArray, searchElement, fromIndex) {
    return arrIndexOf(theArray, searchElement, fromIndex) !== -1;
}
function polyArrFind(theArray, callbackFn, thisArg) {
    var result;
    var idx = polyArrFindIndex(theArray, callbackFn, thisArg);
    return idx !== -1 ? theArray[idx] : result;
}
function polyArrFindIndex(theArray, callbackFn, thisArg) {
    var result = -1;
    arrForEach(theArray, function (value, index) {
        if (fnCall(callbackFn, thisArg | theArray, value, index, theArray)) {
            result = index;
            return -1;
        }
    });
    return result;
}
function polyArrFindLast(theArray, callbackFn, thisArg) {
    var result;
    var idx = polyArrFindLastIndex(theArray, callbackFn, thisArg);
    return idx !== -1 ? theArray[idx] : result;
}
function polyArrFindLastIndex(theArray, callbackFn, thisArg) {
    var result = -1;
    var len = theArray[LENGTH] >>> 0;
    for (var idx = len - 1; idx >= 0; idx--) {
        if (idx in theArray && fnCall(callbackFn, thisArg | theArray, theArray[idx], idx, theArray)) {
            result = idx;
            break;
        }
    }
    return result;
}
function polyArrFrom(theValue, mapFn, thisArg) {
    if (isArray(theValue)) {
        var result_1 = arrSlice(theValue);
        return mapFn ? arrMap(result_1, mapFn, thisArg) : result_1;
    }
    var result = [];
    iterForOf(theValue, function (value, cnt) {
        return result.push(mapFn ? fnCall(mapFn, thisArg, value, cnt) : value);
    });
    return result;
}

var arrFind = _unwrapFunctionWithPoly("find", ArrProto, polyArrFind);
var arrFindIndex = _unwrapFunctionWithPoly("findIndex", ArrProto, polyArrFindIndex);
var arrFindLast = _unwrapFunctionWithPoly("findLast", ArrProto, polyArrFindLast);
var arrFindLastIndex = _unwrapFunctionWithPoly("findLastIndex", ArrProto, polyArrFindLastIndex);

var arrFrom = ArrCls.from || polyArrFrom;

var arrIncludes = _unwrapFunctionWithPoly("includes", ArrProto, polyArrIncludes);
var arrContains = arrIncludes;

var arrReduce = _unwrapFunction("reduce", ArrProto);

var arrSome = _unwrapFunction("some", ArrProto);

var fnBind = _unwrapInstFunction("bind");

var createFnDeferredProxy = function (hostFn, funcName) {
    return function () {
        var theArgs = arrSlice(arguments);
        var theHost = hostFn();
        return fnApply(theHost[funcName], theHost, theArgs);
    };
};
var createProxyFuncs = function (target, host, funcDefs) {
    if (target && host && isArray(funcDefs)) {
        var isDeferred_1 = isFunction(host);
        arrForEach(funcDefs, function (funcDef) {
            var targetName = (funcDef.as || funcDef.n);
            if (funcDef.rp === false && target[targetName]) {
                return;
            }
            target[targetName] = isDeferred_1 ?
                createFnDeferredProxy(host, funcDef.n) :
                fnBind(host[funcDef.n], host);
        });
    }
    return target;
};

var _iterSymbol;
var readArgs = function (theArgs, start, end) {
    if (!_iterSymbol) {
        _iterSymbol = getLazy(function () { return hasSymbol() && getKnownSymbol(3 ); });
    }
    if (!objHasOwn(theArgs, LENGTH)) {
        var iterFn = _iterSymbol.v && theArgs[_iterSymbol.v];
        if (iterFn) {
            var values_1 = [];
            var from_1 = (start === UNDEF_VALUE || start < 0) ? 0 : start;
            var to_1 = end < 0 || start < 0 ? UNDEF_VALUE : end;
            iterForOf(iterFn.call(theArgs), function (value, cnt) {
                if (to_1 !== UNDEF_VALUE && cnt >= to_1) {
                    return -1;
                }
                if (cnt >= from_1) {
                    values_1.push(value);
                }
            });
            if ((start === UNDEF_VALUE || start >= 0) && (end === UNDEF_VALUE || end >= 0)) {
                return values_1;
            }
            theArgs = values_1;
        }
    }
    return arrSlice(theArgs, start, end);
};

var _objCreate = ObjClass["create"];
var objCreate = _objCreate || polyObjCreate;
function polyObjCreate(obj) {
    if (!obj) {
        return {};
    }
    var type = typeof obj;
    if (type !== OBJECT && type !== FUNCTION) {
        throw new TypeError("Prototype must be an Object or function: " + dumpObj(obj));
    }
    function tempFunc() { }
    tempFunc[PROTOTYPE] = obj;
    return new tempFunc();
}

var _isProtoArray;
function objSetPrototypeOf(obj, proto) {
    var fn = ObjClass["setPrototypeOf"] ||
        function (d, b) {
            !_isProtoArray && (_isProtoArray = getLazy(function () {
                var _a;
                return ((_a = {}, _a[__PROTO__] = [], _a) instanceof Array);
            }));
            _isProtoArray.v ? d[__PROTO__] = b : objForEachKey(b, function (key, value) { return d[key] = value; });
        };
    return fn(obj, proto);
}

var _createCustomError = function (name, d, b) {
    _safeDefineName(d, name);
    d = objSetPrototypeOf(d, b);
    function __() {
        this.constructor = d;
        _safeDefineName(this, name);
    }
    d[PROTOTYPE] = b === NULL_VALUE ? objCreate(b) : (__[PROTOTYPE] = b[PROTOTYPE], new __());
    return d;
};
var _safeSetName = function (baseClass, name) {
    try {
        name && (baseClass[NAME] = name);
    }
    catch (e) {
    }
};
var _safeDefineName = function (target, name) {
    try {
        objDefine(target, NAME, { v: name, c: true, e: false });
    }
    catch (e) {
    }
};
function createCustomError(name, constructCb, errorBase) {
    var theBaseClass = errorBase || Error;
    var orgName = theBaseClass[PROTOTYPE][NAME];
    var captureFn = Error.captureStackTrace;
    return _createCustomError(name, function () {
        var _this = this;
        try {
            _safeSetName(theBaseClass, name);
            var _self = fnApply(theBaseClass, _this