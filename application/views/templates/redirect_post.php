<form id="myForm" action="<?= base_url($action) ?>" method="post">
<?= '<input type="hidden" name="'.$post_name.'" value="'.$post_value.'">'; ?>
</form>
<script type="text/javascript">
    document.getElementById('myForm').submit();
</script>