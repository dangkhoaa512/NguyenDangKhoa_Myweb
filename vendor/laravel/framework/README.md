DYN_NAME /* @min:name */] = _internalLogsEventName ? _internalLogsEventName : "InternalMessageId: " + logMessage[_DYN_MESSAGE_ID /* @min:%2emessageId */],
                            _a.iKey = _instrumentationKey,
                            _a[_DYN_TIME /* @min:time */] = toISOString(new Date()),
                            _a.baseType = _InternalLogMessage.dataType,
                            _a.baseData = { message: logMessage[_DYN_MESSAGE /* @min:%2emessage */] },
                            _a);
                        _self.track(item);
                    });
                }
            }
            function _flushChannels(isAsync, callBack, sendReason, cbTimeout) {
                // Setting waiting to one so that we don't call the callBack until we finish iterating
                var waiting = 1;
                var doneIterating = false;
                var cbTimer = null;
                cbTimeout = cbTimeout || 5000;
                function doCallback() {
                    waiting--;
                    if (doneIterating && waiting === 0) {
                        cbTimer && cbTimer[_DYN_CANCEL /* @min:%2ecancel */]();
                        cbTimer = null;
                        callBack && callBack(doneIterating);
                        callBack = null;
                    }
                }
                if (_channels && _channels[_DYN_LENGTH /* @min:%2elength */] > 0) {
                    var flushCtx = _createTelCtx()[_DYN_CREATE_NEW /* @min:%2ecreateNew */](_channels);
                    flushCtx.iterate(function (plugin) {
                        if (plugin.flush) {
                            waiting++;
                            var handled_1 = false;
                            // Not all channels will call this callback for every scenario
                            if (!plugin.flush(isAsync, function () {
                                handled_1 = true;
                                doCallback();
                            }, sendReason)) {
                                if (!handled_1) {
                                    // If any channel doesn't return true and it didn't call the callback, then we should assume that the callback
                                    // will never be called, so use a timeout to allow the channel(s) some time to "finish" before triggering any
                                    // followup function (such as unloading)
                                    if (isAsync && cbTimer == null) {
                                        cbTimer = scheduleTimeout(function () {
                                            cbTimer = null;
                                            doCallback();
                                        }, cbTimeout);
                                    }
                                    else {
                                        doCallback();
                                    }
                                }
                            }
                        }
                    });
                }
                doneIterating = true;
                doCallback();
                return true;
            }
            function _initDebugListener() {
                // Lazily ensure that the notification manager is created
                !_notificationManager && _self[_DYN_GET_NOTIFY_MGR /* @min:%2egetNotifyMgr */]();
                // Will get recalled if any referenced config values are changed
                _addUnloadHook(_configHandler[_DYN_WATCH /* @min:%2ewatch */](function (details