/**
 * Firebase Authentication Module
 * Project: LTD - Lycée Technologie de Diffa
 */

import { 
    signInWithEmailAndPassword, 
    signOut, 
    onAuthStateChanged 
} from "https://www.gstatic.com/firebasejs/10.8.0/firebase-auth.js";
import { doc, getDoc } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-firestore.js";
import { auth, db } from "./firebase-config.js";

/**
 * Log in a staff member
 */
export async function loginStaff(email, password) {
    try {
        const userCredential = await signInWithEmailAndPassword(auth, email, password);
        const user = userCredential.user;
        
        // Fetch user role from Firestore
        const userDoc = await getDoc(doc(db, "users", user.uid));
        if (userDoc.exists()) {
            const userData = userDoc.data();
            localStorage.setItem("ltd_user_role", userData.role);
            localStorage.setItem("ltd_user_name", `${userData.prenom} ${userData.nom}`);
            return { user, role: userData.role };
        } else {
            throw new Error("Profil utilisateur introuvable dans la base de données.");
        }
    } catch (error) {
        console.error("Login Error:", error);
        throw error;
    }
}

/**
 * Monitor Auth State
 */
export function checkAuthState(requiredRole = null) {
    onAuthStateChanged(auth, async (user) => {
        // Detect if we are in a subdirectory
        const isSubdir = window.location.pathname.toLowerCase().includes('/director/') || 
                         window.location.pathname.toLowerCase().includes('/teacher/') || 
                         window.location.pathname.toLowerCase().includes('/supervisor/') || 
                         window.location.pathname.toLowerCase().includes('/student/');
        const root = isSubdir ? "../" : "./";

        if (!user) {
            window.location.href = root + "login-fb.html";
            return;
        }

        const role = localStorage.getItem("ltd_user_role");
        if (requiredRole && role !== requiredRole) {
            window.location.href = root + "login-fb.html?error=Accès non autorisé";
        }
    });
}

/**
 * Log out
 */
export async function logoutUser() {
    try {
        await signOut(auth);
        localStorage.removeItem("ltd_user_role");
        localStorage.removeItem("ltd_user_name");
        
        const isSubdir = window.location.pathname.toLowerCase().includes('/director/') || 
                         window.location.pathname.toLowerCase().includes('/teacher/') || 
                         window.location.pathname.toLowerCase().includes('/supervisor/') || 
                         window.location.pathname.toLowerCase().includes('/student/');
        const root = isSubdir ? "../" : "./";
        
        window.location.href = root + "login-fb.html";
    } catch (error) {
        console.error("Logout Error:", error);
    }
}
