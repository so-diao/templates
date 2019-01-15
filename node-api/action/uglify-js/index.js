
const uglify_js = require('uglify-js')


function to_js_mini(str) {
    const keywords = ['module', 'exports', 'require', 'Object', 'Array', 'RegExp'].filter((key) => str.indexOf(key) > -1)
    return uglify_js.minify('(function(' + keywords.join(',') + '){\n' + str + '\n})(' + keywords.join(',') + ')', {
        toplevel: true
    })
}


module.exports = async (ctx)=>{
    const params = ctx.request.body || {}
    const content = params.content

    if ( !content ) {
        ctx.body = 'content不能为空'
        return
    }
    ctx.body = {
        content: to_js_mini(content).code
    }
}

