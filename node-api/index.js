const koa = require('koa')
const app = new koa()
const router = require('koa-router')()
const cors = require('koa2-cors')
const body_parse = require('koa-body')
const fs = require('fs')
const path = require('path')


const dir_action = path.resolve(__dirname, './action/')


app.use(cors())
app.use(body_parse())

function read_folders() {
    return new Promise((resolve, reject) =>{
        fs.readdir(dir_action, (err, folders) =>{
            if ( !!err ) {
                reject(err)
                return
            }

            resolve(folders)
        })
    })
}


read_folders().then(folders =>{

    folders.forEach(name =>{
        router.post('/' + name, require('./action/' + name))
    })

    app.use(router.routes())
    app.use(router.allowedMethods())
    console.log('启动成功')
})


app.listen(10086)
