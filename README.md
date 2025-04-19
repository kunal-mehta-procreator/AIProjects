# Admin Navigation Project

A Yii2-based administrative interface with dynamic navigation and organization management.

## Requirements

- Docker
- Docker Compose
- Git

## Quick Start

1. Clone the repository:
```bash
git clone <your-repository-url>
cd admin-nav-project
```

2. Build and start the Docker containers:
```bash
docker-compose up -d --build
```

3. Install dependencies:
```bash
docker-compose exec web composer install
```

4. Run database migrations:
```bash
docker-compose exec web php yii migrate --interactive=0
```

5. Access the application:
- Web Interface: http://localhost:8080
- Database: localhost:3306
  - Database: yii2_admin
  - Username: yii2user
  - Password: yii2password

## Project Structure

```
admin-nav-project/
├── commands/           # Console commands
├── config/            # Application configuration
├── controllers/       # Web controllers
├── docker/           # Docker configuration files
├── models/           # Data models
├── views/            # View files
├── web/              # Publicly accessible files
├── widgets/          # Custom widgets
├── docker-compose.yml # Docker Compose configuration
└── Dockerfile        # Docker container configuration
```

## Development

- The application runs in development mode by default
- Source files are mounted into the container for live editing
- Changes to PHP files are immediately reflected
- Database data persists across container restarts

## Docker Commands

- Start containers: `docker-compose up -d`
- Stop containers: `docker-compose down`
- View logs: `docker-compose logs -f`
- Access web container: `docker-compose exec web bash`
- Access database: `docker-compose exec db mysql -uyii2user -pyii2password yii2_admin`

## Contributing

1. Create a new branch for your feature
2. Make your changes
3. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Features

- Modern admin interface
- Responsive navigation
- Role-based access control
- Activity logging
- User management
- Organization setup

## Support

For support, please open an issue in the repository or contact the development team. 