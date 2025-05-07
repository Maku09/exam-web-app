🚀 Tech Stack

Frontend Framework & Tools:

- Vue 3
- Vue Router - Routing -
- Pinia – State management
- Vuelidate – Form validation
- Axios – HTTP client
- uuid – Unique IDs

UI & Styling:

- Tailwind CSS
- @tailwindcss/forms – Form styling plugin
- Heroicons Vue
- @headlessui/vue – Accessible UI components

Build Tool:

- Vite

📁Project Structure

src/
├── api/ # Axios configuration with base URL
├── assets/ # Static assets
├── components/ # Reusable Vue components (Common & Other Product components)
├── router/ # Vue Router configuration
├── store/ # Pinia stores
├── views/ # Route-based views
├── App.vue # Root component
├── main.ts # Entry point

Configuration
🔐 Note: .env file is not included or used in this project.

Axios is pre-configured in src/api/axios.ts to use the base URL:
https://fakestoreapi.com/

# Clone the repo

git clone https://github.com/Maku09/exam-web-app
cd exam-web-app

# Install dependencies

npm install or yarn

# Start development server

npm run dev or yarn dev
