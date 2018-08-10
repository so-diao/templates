
(function(w, doc) {

    var $ = w.jQuery


    $.rem = function () {
        var width = $(w).width()
        var centerWidth = w.config.centerWidth
        
		$('html').css({
			'fontSize': (width >= centerWidth ? centerWidth : width) / (centerWidth / 100) + 'px'
		})
    }

    $.rem.setup = function(action) {

        switch( action ) {
            case 'bind':
                $.rem()
                $(w).off('resize', $.rem).on('resize', $.rem)
                break
            
            case 'unbind':
                $('html').css('fontSize', '')
                $(w).off('resize', $.rem)
                break
        }
    }

    $.rem.setup('bind')


})(window, document)