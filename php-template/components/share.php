
<div class="share">
    <div class="qrcode"></div>
</div>

<script>
(function() {

    var href = window.location.href
    window.addEventListener('load', function() {
        $('.share .qrcode').qrcode({ 
            render: 'canvas',
            width: 100,
            height: 100,
            text: href
        })
    })

})()
</script>