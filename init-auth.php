<?php

$discord_url = "https://discord.com/api/oauth2/authorize?client_id=1070287344810328114&redirect_uri=http%3A%2F%2Flocalhost%2FDiscord%2Fprocess-auth.php&response_type=code&scope=identify%20guilds";
header("Location: $discord_url");
exit();

?>