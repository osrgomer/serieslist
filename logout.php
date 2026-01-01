<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging out... | SeriesList</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .spinner {
            border: 3px solid rgba(79, 70, 229, 0.1);
            border-top: 3px solid #4f46e5;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen">

    <div class="text-center space-y-6 bg-white p-8 rounded-2xl shadow-lg border border-slate-200">
        <div class="spinner mx-auto"></div>
        <div class="space-y-2">
            <h1 class="text-slate-800 font-bold text-xl tracking-tight">Signing out</h1>
            <p class="text-sm text-slate-600">Safely clearing your session...</p>
        </div>
    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
        import { getAuth, signOut } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-auth.js";

        async function performLogout() {
            try {
                // Initialize Firebase
                const firebaseConfig = window.__firebase_config ? JSON.parse(window.__firebase_config) : { apiKey: "mock" };
                const app = initializeApp(firebaseConfig);
                const auth = getAuth(app);

                // Sign out from Firebase
                await signOut(auth);

                // Clear local sessions
                localStorage.clear();
                sessionStorage.clear();

                // Redirect logic
                setTimeout(() => {
                    // Fix: Use an absolute-style path or a safe relative path for the environment
                    const currentPath = window.location.pathname;
                    const basePath = currentPath.substring(0, currentPath.lastIndexOf('/') + 1);
                    window.location.href = `${window.location.origin}${basePath}index.html`;
                }, 1500);

            } catch (error) {
                console.error("Logout error:", error);
                // Fallback redirect
                const currentPath = window.location.pathname;
                const basePath = currentPath.substring(0, currentPath.lastIndexOf('/') + 1);
                window.location.href = `${window.location.origin}${basePath}index.html`;
            }
        }

        window.onload = performLogout;
    </script>
</body>
</html>