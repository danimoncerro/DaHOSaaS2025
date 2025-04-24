
# 🛒 My-SaaS-App – Proiect 2.0.1

**Platformă SaaS personalizabilă pentru magazine online**, dezvoltată de la zero. Fiecare abonat poate crea și gestiona propriul magazin online cu funcționalități complete.

---

## 🚀 Funcționalități principale

- ✅ Sistem de autentificare pentru abonați și clienți
- ✅ Dashboard pentru abonați cu creare de magazine
- ✅ Template-uri predefinite pentru magazine (ex: Sneakers, Fructe & Legume)
- ✅ Dashboard individual pentru fiecare magazin
- ✅ Gestionare produse (CRUD + imagine)
- ✅ Coș de cumpărături cu sesiuni
- ✅ Finalizare comenzi + salvare în baza de date (`orders`, `order_items`)
- ✅ Template „Fructe și Legume” complet personalizabil:
  - Titlu, slogan, culori (header și fundal)
  - Setări salvate în baza de date (`store_settings`)

---

## 🧱 Tehnologii folosite

- **Backend:** PHP 7+
- **Frontend:** HTML5, CSS3, Bootstrap 4, FontAwesome
- **Bază de date:** MySQL
- **Altele:** Git, GitHub, XAMPP pentru dezvoltare locală

---

## 🗂️ Structura proiectului

```
/config
    config.php
/public
    index.php
    login.php
    register.php
/stores
    /online_stores/{store_name}
        {store_name}.php
        {store_name}_admin_dashboard.php
    /settings
        template_admin_dashboard.php
        template_fruits_veggies.php
        cart.php
        checkout.php
        add_to_cart.php
        remove_from_cart.php
        update_store_style.php
/views, /controllers, /models (dacă e activat sistemul MVC)
```

---

## ⚙️ Instalare locală

1. Clonează repository-ul:
```bash
git clone https://github.com/utilizator/my-saas-app.git
```

2. Creează baza de date `my_saas_app` și importă fișierul `my_saas_app.sql`

3. Setează corect datele de conectare în `config/config.php`

4. Rulează aplicația local cu XAMPP/Apache și accesează:
```
http://localhost/my-saas-app/public/index.php
```

---

## 📦 Fișiere importante de ignorat (se află în .gitignore)

```
/config/config.php
/public/images/
/uploads/
/vendor/
/node_modules/
```

---

## 🧪 Recomandări de testare

- Creează un cont de abonat și un magazin folosind un template
- Adaugă produse, vizualizează public magazinul
- Testează adăugarea în coș și finalizarea unei comenzi
- Încearcă secțiunea „Personalizare” din dashboard-ul admin

---

## 🧑‍💻 Dezvoltat de

**DaHo Tech Solutions**  
Slogan: *Soluții inteligente pentru afacerea ta!*

---

## 📌 Notițe finale

- Fiecare magazin e generat dintr-un **template presetat**, dar complet personalizabil
- Se pot adăuga noi template-uri în `stores/settings/`
- Sistemul suportă extindere pentru statistici, notificări și integrare cu plăți

---

✨ Pentru orice sugestii sau idei noi – contribuțiile sunt binevenite!