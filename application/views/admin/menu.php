<?php
$this->config->load('menu', TRUE);
$menu = $this->config->item('menu', 'menu');
foreach ($menu as $k => $v) {
    ?>
    <p><?php echo $k ?><span class="sjx_out"></span></p>
    <ul>
        <?php foreach ($v as $kk => $vv) { ?>
            <a href="<?php echo base_url('admin/index/' . $kk) ?>" ><li <?php if ($li == $kk) echo 'class="li_on"'; ?>><?php echo $vv ?></li></a>
        <?php } ?>
    </ul>
<?php } ?>
<script>
    $(function() {
        $('.body_left p').click(function() {
            $(this).next().slideToggle('slow');
            var span = $(this).children('span');
            if (span.hasClass('sjx_out')) {
                span.removeClass('sjx_out').addClass('sjx_on');
            } else {
                span.removeClass('sjx_on').addClass('sjx_out');
            }
        });
        $('.li_on').parents().show().prev('p').children('span').removeClass('sjx_out').addClass('sjx_on');
    })
</script>