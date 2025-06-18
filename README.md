# Laravel + OpenAI Integration 🚀

This project demonstrates integration between **Laravel 12**, **React.js**, **Inertia.js**, and **OpenAI API** to build
an intelligent **Support Ticket Classifier**.

The goal is to showcase Laravel backend capabilities along with AI-powered automation using LLM (Large Language Models).
It includes a working UI and a RESTful API to create and view support tickets that are automatically categorized by the
LLM.

---

## 🔧 Tech Stack

- **Backend**: Laravel 12
- **Frontend**: React.js with Inertia.js
- **AI Integration**: OpenAI via [Laravel Prism](https://github.com/prism-php/prism)
- **Database**: MySQL

---

## 🎯 Features

- Create and view support tickets
- Automatic classification using OpenAI
- Asynchronous LLM processing using Laravel Queues & Jobs
- Status tracking: `pending`, `processing`, `completed`, `failed`
- Clean UI with real-time classification
- REST API with Postman collection
- Error logging and retry mechanism

---

## 📁 Database Structure

### 📝 Support Tickets Table

- `id`
- `name`
- `message`
- `type` (`billing | technical_support | account_management | feature_request`)
- `type_status`: `pending | completed | failed`
- `created_at`
- `updated_at`

### 🧠 LLM Responses Table

- `id`
- `support_ticket_id`
- `request` (sent to LLM)
- `response` (from LLM)
- `created_at`
- `updated_at`

---

## 🚀 Setup & Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/laravel-openai-integration.git
   cd laravel-openai-integration
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Configure `.env`**
   ```env
   OPENAI_API_KEY=your-openai-api-key
   ```

4. **Run migrations**
   ```bash
   php artisan migrate
   ```

5. **Queue worker**
   ```bash
   php artisan queue:work
   ```

6. **Serve the app**
   ```bash
   php artisan serve
   ```

---

## 📬 API Endpoints

| Method | Endpoint                    | Description         |
|--------|-----------------------------|---------------------|
| GET    | `/api/support-tickets`      | List all tickets    |
| POST   | `/api/support-tickets`      | Create a new ticket |
| GET    | `/api/support-tickets/{id}` | Get single ticket   |

🔗 **Postman Collection**:  
[Laravel + OpenAI Integration API](https://www.postman.com/docking-module-architect-45770649/public-space/collection/dtvptyq/laravel-openai-integration)

---

## 💻 Demo

🌐 **Live Demo**:  
[https://laravel-openai-integration-main-umy5yi.laravel.cloud/](https://laravel-openai-integration-main-umy5yi.laravel.cloud/)

✅ Anyone can register and test the app.
