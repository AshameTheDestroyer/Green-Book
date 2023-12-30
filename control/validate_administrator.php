<?php
if (!$_SESSION["user"]["is_administrator"]) {
    exit("
        <main id=\"unauthorized-page\" style=\"
            display: flex;
            place-content: center;
            place-items: center;
        \">
            <section style=\"
                display: flex;
                flex-direction: column;
                gap: 2rem;
            \">
                <h1>Unauthorized Page</h1>
                <p>You don't have enough permissions to enter this page.</p>
            </section>
        </main>
    ");
}
?>