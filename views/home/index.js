
document.getElementById("logout-link").addEventListener("click", function(e) {
    e.preventDefault();

    const cookies = document.cookie.split('; ');
    const tokenCookie = cookies.find(row => row.startsWith('remember_token='));

    if (!tokenCookie) {
        // No hay token, redirige directo
        window.location.href = '../../index.php';
        return;
    }

    const token = tokenCookie.split('=')[1];

    fetch("http://127.0.0.1:8000/api/logout", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "remember-token": token
            
        }
    })
    .then(res => res.json())
    .then(data => {
        // Borrar la cookie
        document.cookie = "remember_token=; path=/; max-age=0";

        // Redirigir
        window.location.href = "../../index.php";
    });
});
