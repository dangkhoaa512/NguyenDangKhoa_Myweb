                   s: function (newValue) {
                        _self.updateCfg(newValue, false);
                    }
                });
                objDefine(_self, "pluginVersionStringArr", {
                    g: function () {
                        if (!_pluginVersionStringArr) {
                            _setPluginVersions();
                        }
                        return _pluginVersionStringArr;
                    }
                });
                objDefine(_self, "pluginVersionString", {
                    g: function () {
                        if (!_pluginVersionString) {
                            if (!_pluginVersionStringArr) {
                                _setPluginVersions();
                            }
                            _pluginVersionString = _pluginVersionStringArr.join(";");
                        }
                        return _pluginVersionString || STR_EMPTY;
                    }
                });
                objDefine(_self, "logger", {
                    g: