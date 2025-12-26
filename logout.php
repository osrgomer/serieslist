<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging out... | SeriesList</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #14181c; color: #9ab; font-family: -apple-system, sans-serif; }
        .spinner {
            border: 3px solid rgba(0, 224, 84, 0.1);
            border-top: 3px solid #00e054;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="text-center space-y-6">
        <div class="spinner mx-auto"></div>
        <div class="space-y-2">
            <h1 class="text-white font-bold text-xl tracking-tight">Signing out</h1>
            <p class="text-sm text-[#678]">Safely clearing your session...</p>
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