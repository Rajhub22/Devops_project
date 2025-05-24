# Use a base image
FROM node:18

# Set working directory
WORKDIR /app

# Copy files
COPY . .

# Install dependencies
RUN npm install

# Start the app
CMD ["npm", "start"]

EXPOSE 8080
