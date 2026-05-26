micHandler, theValue, dfName, dfValue);
                });
            }
        }
    }
    else if (defValue) {
        theValue = _resolveDefaultValue(dynamicHandler, theConfig, defValue);
    }
    else {
        theValue = defValue;
    }
    dynamicHandler.set(theConfig, name, theValue);
    if (reference) {
        dynamicHandler.ref(theConfig, name);
    }
    if (readOnly) {
        dynamicHandler[_DYN_RD_ONLY ](theConfig, name);
    }
}

var CFG_HANDLER_LINK = symbolFor("[[ai_dynCfg_1]]");
var BLOCK_DYNAMIC = symbolFor("[[ai_blkDynCfg_1]]");
var FORCE_DYNAMIC = symbolFor("[[ai_frcDynCfg_1]]");
function _cfgDeepCopy(source) {
    if (source) {
        var target_1;
        if (isArray(source)) {
            target_1 = [];
            target_1[_DYN_LENGTH$2 ] = source[_DYN_LENGTH$2 ];
        }
        else if (isPlainObject(source)) {
            target_1 = {};
        }
        if (target_1) {
            objForEachKey(source, function (key, value) {
                target_1[key] = _cfgDeepCopy(value);
            });
            return target_1;
        }
    }
    return source;
}
function getDynamicConfigHandler(value) {
    if (value) {
        var handler = value[CFG_HANDLER_LINK] || value;
        if (handler.cfg && (handler.cfg === value || handler.cfg[CFG_HANDLER_LINK] === handler)) {
            return handler;
        }
    }
    return null;
}
function blockDynamicConversion(value) {
    if (value && (isPlainObject(value) || isArray(value))) {
        try {
            value[BLOCK_DYNAMIC] = true;
        }
        catch (e) {
        }
    }
    return value;
}
function _canMakeDynamic(getFunc, state, value) {
    var result = false;
    if (value && !getFunc[state.blkVal]) {
        result = value[FORCE_DYNAMIC];
        if (!result && !value[BLOCK_DYNAMIC]) {
            result = isPlainObject(value) || isArray(value);
        }
    }
    return result;
}
function throwInvalidAccess(message) {
    throwTypeError("InvalidAccess:" + message);
}

var arrayMethodsToPatch = [
    "push",
    "pop",
    "shift",
    "unshift",
    "splice"
];
var _throwDynamicError = function (logger, name, desc, e) {
    logger && logger[_DYN_THROW_INTERNAL ](3 , 108 , "".concat(desc, " [").concat(name, "] failed - ") + dumpObj(e));
};
function _patchArray(state, target, name) {
    if (isArray(target)) {
        arrForEach(arrayMethodsToPatch, function (method) {
            var orgMethod = target[method];
            target[method] = function () {
                var args = [];
                for (var _i = 0; _i < arguments.length; _i++) {
                    args[_i] = arguments[_i];
                }
                var result = orgMethod[_DYN_APPLY ](this, args);
   