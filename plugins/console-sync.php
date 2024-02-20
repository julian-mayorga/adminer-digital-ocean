<?php

class ConsoleSyncPlugin
{
    public function head()
    {
        ?>
        <script<?php echo nonce(); ?>>
            window.addEventListener("beforeunload", function (event) {
                window.parent.postMessage(`adminer:unload:${window.location.href}`, "*");
            });
            window.addEventListener("load", function (event) {
                window.parent.postMessage(`adminer:load:${window.location.href}`, "*");
            });
            window.addEventListener("message", function (event) {
                // Validate the origin of the message for security
                // if (event.origin !== "https://your-trusted-origin.com") {
                // return;
                // }
                if (typeof event.data !== "string" || !event.data.startsWith('console:')) {
                    return
                }
                const data = JSON.parse(event.data.split('console:')[1])
                const dbType = data.type
                if (!dbType) {
                    return
                }
                if (!document.querySelector('input[type="submit"][value="Login"]')) {
                    window.location.href = '/';
                    return
                }
                // When / is loaded, select DB type
                const select = document.querySelector('select[name="auth[driver]"]')
                select.value = dbType
                const server = document.querySelector('input[name="auth[server]"]')
                server.value = data.server
                const username = document.querySelector('input[name="auth[username]"]')
                username.value = data.username
                const password = document.querySelector('input[name="auth[password]"]')
                password.value = data.password
                const database = document.querySelector('input[name="auth[db]"]')
                database.value = data.database
                const submit = document.querySelector('input[type="submit"][value="Login"]')
                submit.click()

            });
        </script>
            <?php
    }
}

return new ConsoleSyncPlugin();