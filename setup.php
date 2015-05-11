<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0">
    <title>Localhost setup</title>
    <link rel="stylesheet" href="index-assets/setup.css">
</head>
<body>
    <?php
        // Submit handle.
        if (isset($_POST['submit']) && isset($_POST['hotlinks']) && isset($_POST['tools']) && isset($_POST['project_dir'])) {
            $hotlinks = $_POST['hotlinks'];
            $tools = $_POST['tools'];
            $project_dir = $_POST['project_dir'];

            // Store hotlinks in array.
            $hotlink_arr = array();
            if ($hotlinks) {
                foreach(explode("\n", $hotlinks) as $hotlink) {
                    if (preg_match('~^(.*?) % (.*)$~', $hotlink, $matches)) {
                        $hotlink_arr[] = array(
                            'title' => $matches[1],
                            'href' => $matches[2],
                        );
                    }
                }
            }
            // Store tools in array.
            $tools_arr = array();
            if ($tools) {
                foreach(explode("\n", $tools) as $tool) {
                    if (preg_match('~^(.*?) % (.*)$~', $tool, $matches)) {
                        $tools_arr[] = array(
                            'title' => $matches[1],
                            'href' => $matches[2],
                        );
                    }
                }
            }

            // Combine arrays.
            $config_arr = array(
                'hotlinks' => $hotlink_arr,
                'tools' => $tools_arr,
                'project_dir' => $project_dir,
            );

            // Convert to JSON
            $config_json = json_encode($config_arr);

            file_put_contents('index-assets/config.json', $config_json);
            header('Location: index.php');
        }
    ?>

    <form action="" method="post" accept-charset="utf-8">

        <label for="hotlinks">Hotlinks</label>
        <p class="note">Enter each value on a new line as follows:</p>
        <p class="note">Link title % http://www.link-to-site.com</p>
        <textarea id="hotlinks" name="hotlinks"></textarea>

        <label for="tools">Tools</label>
        <p class="note">Enter each value on a new line as follows:</p>
        <p class="note">Link title % http://www.link-to-site.com</p>
        <textarea id="tools" name="tools"></textarea>

        <label for="tools">Project directory</label>
        <p class="note">Leave empty for root folder.</p>
        <p class="note">No leading or trailing slashes.</p>
        <input type="text" name="project_dir" value="" placeholder="Project directory">

        <input type="submit" name="submit" value="Save setup">
    </form>
</body>
</html>
