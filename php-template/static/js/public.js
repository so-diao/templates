
(function(w, doc) {

    var $ = w.jQuery
    var eabbr = {}


    eabbr.rem = function () {
        var width = $(w).width()
        var centerWidth = w.config.centerWidth

		$('html').css({
			'fontSize': (width >= centerWidth ? centerWidth : width) / (centerWidth / 100) + 'px'
		})
    }

    eabbr.rem.setup = function(action) {

        switch( action ) {
            case 'bind':
                eabbr.rem()
                $(w).off('resize', eabbr.rem).on('resize', eabbr.rem)
            break
            case 'unbind':
                $('html').css('fontSize', '')
                $(w).off('resize', eabbr.rem)
            break
        }
    }

    eabbr.rem.setup('bind')

    eabbr.getUrlParam = function(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)")
        var r = window.location.search.substr(1).match(reg)
        if (r != null) return decodeURIComponent(r[2]); return null
    }

    w.eabbr = eabbr
})(window, document)