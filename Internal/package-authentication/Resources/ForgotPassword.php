<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

<table class="table table-bordered">
    <tr>
        <th colspan="2"><?php echo ZN\Lang::select('Authentication', 'verificationEmail')?></th>
    </tr>
    <tr>
        <td><?php echo ZN\Lang::select('Authentication', 'username')?></td>
        <td><?php echo $user; ?></td>
    </tr>
    <tr>
        <td><?php echo ZN\Lang::select('Authentication', 'password')?></td>
        <td><?php echo $pass; ?></td>
    </tr>

    <tr>
        <td colspan="2">
            <a href="<?php echo $url; ?>"><?php echo ZN\Lang::select('Authentication', 'learnNewPassword'); ?></a>
        </td>
    </tr>
</pre>