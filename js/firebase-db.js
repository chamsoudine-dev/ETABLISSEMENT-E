/**
 * Firebase Firestore Data Module
 * Project: LTD - Lycée Technologie de Diffa
 */

import { 
    collection, 
    addDoc, 
    updateDoc, 
    doc, 
    query, 
    where, 
    orderBy,
    limit,
    onSnapshot, 
    getDocs, 
    serverTimestamp,
    setDoc
} from "https://www.gstatic.com/firebasejs/10.8.0/firebase-firestore.js";
import { db } from "./firebase-config.js";

/**
 * Teachers / Users Management
 */
export const getTeachers = (callback) => {
    const q = query(collection(db, "users"), where("role", "==", "enseignant"));
    return onSnapshot(q, (snapshot) => {
        const teachers = snapshot.docs.map(doc => ({ id: doc.id, ...doc.data() }));
        callback(teachers);
    });
};

/**
 * Classes Management
 */
export const getClasses = (callback) => {
    return onSnapshot(collection(db, "classes"), (snapshot) => {
        const classes = snapshot.docs.map(doc => ({ id: doc.id, ...doc.data() }));
        callback(classes);
    });
};

/**
 * Students Management
 */
export const getStudentsByClass = (classeId, callback) => {
    const q = query(collection(db, "eleves"), where("classeId", "==", classeId));
    return onSnapshot(q, (snapshot) => {
        const students = snapshot.docs.map(doc => ({ id: doc.id, ...doc.data() }));
        callback(students);
    });
};

/**
 * Grades Management (Real-time)
 */
export const saveNote = async (eleveId, assignationId, trimestre, typeNote, note) => {
    const noteId = `${eleveId}_${assignationId}_${trimestre}_${typeNote}`;
    await setDoc(doc(db, "notes", noteId), {
        eleveId,
        assignationId,
        trimestre,
        typeNote,
        note: parseFloat(note),
        updatedAt: serverTimestamp()
    }, { merge: true });
};

export const getNotesByStudent = (eleveId, callback) => {
    const q = query(collection(db, "notes"), where("eleveId", "==", eleveId));
    return onSnapshot(q, (snapshot) => {
        const notes = snapshot.docs.map(doc => ({ id: doc.id, ...doc.data() }));
        callback(notes);
    });
};

/**
 * Notifications (Real-time Director to Staff)
 */
export const sendNotification = async (message) => {
    await addDoc(collection(db, "notifications"), {
        message,
        from: localStorage.getItem("ltd_user_name") || "Direction",
        timestamp: serverTimestamp()
    });
};

export const listenNotifications = (callback) => {
    const q = query(collection(db, "notifications"), orderBy("timestamp", "desc"), limit(1));
    return onSnapshot(q, (snapshot) => {
        if (!snapshot.empty) {
            callback(snapshot.docs[0].data());
        }
    });
};
