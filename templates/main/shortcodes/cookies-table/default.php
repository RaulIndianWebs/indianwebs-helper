<table class="cookies-table" style="width:100%;border-collapse:collapse;">    
    <thead>
        <tr style="background:#f5f5f5;">
            <th style="border:1px solid #ccc;padding:5px;">Cookie Name</th>
            <th style="border:1px solid #ccc;padding:5px;">Expiration</th>
            <th style="border:1px solid #ccc;padding:5px;">Category</th>
            <th style="border:1px solid #ccc;padding:5px;">Description</th>
        </tr>
    </thead>';
    <tbody>
    <?php foreach ($cookies as $cookie) : ?>
        <tr>
            <td style="border:1px solid #ccc;padding:5px;"> <?php echo esc_html($cookie['public_name']); ?></td>
            <td style="border:1px solid #ccc;padding:5px;"> <?php echo esc_html($cookie['cookie_expiration']); ?></td>
            <td style="border:1px solid #ccc;padding:5px;"> <?php echo esc_html($cookie['cookie_category']); ?></td>
            <td style="border:1px solid #ccc;padding:5px;"> <?php echo esc_html($cookie['cookie_description']); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>