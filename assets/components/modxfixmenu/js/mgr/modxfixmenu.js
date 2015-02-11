(function(history){
  var pushState = history.pushState;
  history.pushState = function(state) {
    if (typeof history.onpushstate == "function") {
      history.onpushstate({state: state});
    }
    return pushState.apply(history, arguments);
  }
})(window.history);

window.MODxFixMenu = (function () {
  return {
    timeout: MODxFixMenuConfig.timeout || 0,
    timers: {},
    className: MODxFixMenuConfig.className || 'opened',
    stateOpened: 0,
    loadingPage: 0,
    needInit: function () {
      return !Ext.get('MODxFixMenu');
    },
    setInitFlag: function () {
      var body = document.getElementsByTagName('body')[0];
      var MODxFixMenuDiv = document.createElement('div');
      MODxFixMenuDiv.id = 'MODxFixMenu';
      body.appendChild(MODxFixMenuDiv);
    },
    init: function () {
      // console.log('run init!');
      var self = this;
      if (!self.needInit()) {
        // console.log('init not needed');
        return;
      }

      window.onpopstate = history.onpushstate = function(e) {
        console.log('change history state');
        self.loadingPage = 1;
        self.closeAll();
      };
      MODx.on('beforeLoadPage', function(url) {
        console.log('before load page');
        self.loadingPage = 1;
      });
      Ext.onReady(function () {
        self.setInitFlag();

        if (self.timeout) {
          Ext.get(Ext.query('#modx-navbar ul')).hover(
              function (e, t) {
                var list = e.getTarget('ul', 5, true);
                if (!list) { return; }
                var item = list.findParent('li', 3, true);
                if (!item) { return; }

                // console.log('clearTimeout!', self.timers[item.id], item.id);
                if (typeof self.timers[item.id] != 'undefined') {
                  clearTimeout(self.timers[item.id]);
                  self.timers[item.id] = 0;
                }
              },
              function (e, t) {
                var list = e.getTarget('ul', 5, true);
                if (!list) { return; }
                var item = list.findParent('li', 3, true);
                if (!item) { return; }

                if (typeof self.timers[item.id] != 'undefined' && self.timers[item.id]) {
                  clearTimeout(self.timers[item.id]);
                  self.timers[item.id] = 0;
                }

                // console.log('set timeout', self.timers[item.id], item.id);
                self.timers[item.id] = setTimeout(function () {
                  self.close(item.dom);
                }, self.timeout);
              }
          );
        }

        Ext.getBody().on({
          click: function (e, target, event) {
            var items = self.getParentMenuItems(target);
            if (items.length) {
              // console.log('click');
              if (self.loadingPage) {
                // console.log('self.loadingPage', self.loadingPage);
                self.loadingPage = 0;
                self.closeAll();
                return;
              }

              self.closeAll();

              self.stateOpened = 1;
              // console.log('add to needed!');
              Ext.get(items).addClass(self.className);
            } else if (self.stateOpened) {
              self.closeAll();
            }
          }
        });
      });
    },
    close: function (node) {
      var self = this;
      if (!node) return;
      // console.log('close', Ext.get(node));
      Ext.get(node).removeClass(self.className);
    },
    closeAll: function () {
      var self = this;
      if (self.stateOpened) {
        // console.log('close all!');
        self.stateOpened = 0;
        Ext.get(Ext.query('#modx-navbar li.'+ self.className)).removeClass(self.className);
      }
    },
    getParentMenuItems: function (element, items) {
      var self = this;
      items = items || [];
      if (!items.length && !Ext.get(element).findParent('#modx-navbar')) {
        return items;
      }

      var _element = Ext.get(element);
      element = _element.dom;
      var parent = _element.findParent('li');
      if (parent) {
        if (!items.length) {
          items.push(parent);
        } else {
          parent = Ext.get(parent.parentNode).findParent('li');
          if (parent) {
            items.push(parent);
          }
        }
      }
      if (parent) {
        items = self.getParentMenuItems(parent, items);
      }

      return items;
    }
  };
})();

MODxFixMenu.init();