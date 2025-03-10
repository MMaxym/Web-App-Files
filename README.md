
# Web Application for file storage and viewing

## Project description
This web application allows users to upload, store, view, and manage files securely and efficiently, featuring automatic deletion, link generation for file access, and activity reporting.

---

## Functionality 
- User registration and authentication.
- File uploads with comments and automatic deletion dates.
- Viewing a file list sorted by creation date.
- Generating links for public viewing and one-time access tokens.
- Displaying file usage analytics through reports.
- Automatic checking and deletion of files with expired dates. 

---

## Project deployment instructions

### 1. Cloning the repository
Clone the project from GitHub:
```bash
git clone https://github.com/MMaxym/Web-App-Files
cd Web-App-Files
```

### 2. Environment setup
Copy the .env file for configuration:
```bash
cp .env.example .env
```
Configure in the `.env` file:
- **APP_URL**: The project's URL, for example, `http://localhost`.
- **DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD**: Database access configuration settings.

Generate the application key:
```bash
docker exec -it web-app-files php artisan key:generate
```

### 3. Running with Docker
Start the Docker containers:
```bash
docker-compose up -d
```

### 4. Installing Dependencies
Install PHP dependencies:
```bash
docker exec -it web-app-files composer install
```
Install Node.js dependencies:
```bash         
docker exec -it web-app-files npm install
npm run build
```

### 5. Migrations
Run the database migration:
```bash
docker exec -it web-app-files php artisan migrate
```

### 6. Running the application
Open your browser and navigate to the address specified in the **APP_URL** variable in the `.env` file (for example, [http://localhost](http://localhost)) to start using the application.

---

## Core Technologies
- **Backend**: Laravel
- **Frontend**: Blade and SPA via Nuxt.js API
- **Containers**: Docker & Docker Compose


---

## Authors
- **Maxym Melnyk**
- Explore more on [GitHub](https://github.com/MMaxym)
