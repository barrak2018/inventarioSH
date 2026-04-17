export class AuthService {
    constructor(url) {
        this.url = url;
    }

    async login(cedula, password) {
        const response = await fetch(this.url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ cedula, password })
        });

        const data = await response.json();
        if (!response.ok) throw new Error(data.msg || "Error en el servidor");
        return data;
    }

    async logout() {
        // Implementar un php simple que haga session_destroy()
        return await fetch('api/logout.php');
    }
}