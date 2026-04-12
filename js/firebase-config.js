/**
 * Firebase Configuration and Initialization
 * Project: LTD - Lycée Technologie de Diffa
 */

// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
import { initializeAppCheck, ReCaptchaV3Provider } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app-check.js";
import { getFirestore } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-firestore.js";
import { getAuth } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-auth.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-analytics.js";

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyCKTTOVJYmNL8uGIsOwSAlswmKwcj2rf3Y",
  authDomain: "etablissement-c3024.firebaseapp.com",
  projectId: "etablissement-c3024",
  storageBucket: "etablissement-c3024.firebasestorage.app",
  messagingSenderId: "297182802162",
  appId: "1:297182802162:web:b1f95cae80a14467dee06b"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

// Initialize App Check (Self-hosted reCAPTCHA v3 or Enterprise)
// Note: You must obtain a site key from Google reCAPTCHA
const appCheck = initializeAppCheck(app, {
  provider: new ReCaptchaV3Provider('RECAPTCHA_SITE_KEY_HERE'),
  isTokenAutoRefreshEnabled: true
});

const db = getFirestore(app);
const auth = getAuth(app);
const analytics = getAnalytics(app);

// Expose to window for access in non-module scripts
window.firebaseApp = app;
window.firestore = db;
window.firebaseAuth = auth;

console.log("Firebase initialized successfully for Project: etablissement-c3024");

export { app, db, auth, analytics };
