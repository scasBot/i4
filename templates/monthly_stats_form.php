<div class="profile-wrapper">
    <h1>Monthly Statistics</h1>
    <p>Total time logged: <?php echo $hours ?>h <?php echo $minutes ?>m <?php echo $seconds ?>s</p>
    <p>Number of client contacts: <?php echo $client_count ?></p>
    <p>Number of unique clients: <?php echo $unique_client_count ?></p>
    <table class="table table-bordered table-hover" style="width: 80%; cursor: pointer">
        <thead>
            <tr>
                <th>Name</th>
                <th>Time Logged</th>
        </thead>
        <tbody>
            <?php foreach($active_users as $user => $user_time) : ?>
                <tr class="user">
                    <td><?php echo $user ?></td>
                    <td><?php echo $user_time ?></td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>