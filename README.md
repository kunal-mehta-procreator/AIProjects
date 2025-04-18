# Admin Navigation Project

A modern admin interface built with Yii2 Framework, featuring a responsive navigation system and clean design.

## Prerequisites

- Docker Desktop
- Git

## Quick Start

1. Clone the repository:
```bash
git clone [your-repository-url]
cd admin-nav-project
```

2. Start the application:
```bash
docker-compose up -d
```

3. Visit http://localhost:8080/admin/dashboard

## Development Setup Without Docker

### Requirements
- PHP 8.2+
- Composer
- MySQL/MariaDB

### Installation Steps

1. Install dependencies:
```bash
composer install
```

2. Create required directories:
```bash
mkdir -p runtime web/assets
chmod 777 runtime web/assets
```

3. Start development server:
```bash
php -S localhost:8080 -t web
```

## Project Structure

```
admin-nav-project/
├── modules/                    # Application modules
│   └── admin/                 # Admin module
├── views/                     # View files
│   └── layouts/              # Layout files
├── web/                      # Public directory
│   ├── css/                 # CSS files
│   └── js/                  # JavaScript files
├── config/                   # Configuration files
├── docker/                   # Docker configuration
├── composer.json            # Composer dependencies
└── docker-compose.yml       # Docker Compose configuration
```

## Features

- Modern admin interface
- Responsive navigation
- Role-based access control
- Activity logging
- User management
- Organization setup

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Docker Commands

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs -f

# Rebuild containers
docker-compose up --build -d
```

## Troubleshooting

### Common Issues

1. Permission Issues
```bash
chmod -R 777 runtime web/assets
```

2. Composer Issues
```bash
docker-compose exec web composer install
```

3. Cache Issues
```bash
docker-compose exec web php yii cache/flush-all
```

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, please open an issue in the repository or contact the development team. 