(self.webpackChunk=self.webpackChunk||[]).push([[733],{799:()=>{!function(t){"use strict";t(".btn-outline-secondary").click((function(e){e.preventDefault(),t(this).addClass("disabled");let i=t(this).attr("href"),s=t(this).parent().parent().parent();s.css({opacity:"0.5"}),t.get(i).done((function(){s.fadeOut(),function(){let e=t(".js-counter"),i=e.text();i=Number.parseInt(i),i-=1,e.text(i)}()}))}))}($)},437:()=>{!function(t){"use strict";let e=window.location.href;-1!==e.indexOf("profile")?t(".list-group-item-action:eq(2)").addClass("active"):-1!==e.indexOf("unpublished")?t(".list-group-item-action:eq(1)").addClass("active"):t(".list-group-item-action:eq(0)").addClass("active")}($)},346:(t,e,i)=>{"use strict";i(437),i(799)}},t=>{var e;e=346,t(t.s=e)}]);