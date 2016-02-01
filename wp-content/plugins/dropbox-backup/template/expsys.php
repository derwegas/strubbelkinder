<?php 
    $str = '';
    foreach($data['sys'] as $key => $value) {
        $str .= $value['function'];
    }
?>
<script>
    function showView()
    {
        if(jQuery('.body-functions-view').css('display') == 'none') {
            jQuery('.body-functions-view').show('slow');
        } else {
            jQuery('.body-functions-view').hide('slow');
        }
    }
</script>
<div class="functions-view">
    <div class="title-functions-view" onclick="showView();">
        <?php echo $str; ?>
    </div>
    <div class="body-functions-view">
        <?php echo $functions_need; ?>
    </div>
</div>
<?php
