# Use official Nginx image
FROM nginx:alpine

# Remove default Nginx files
RUN rm -rf /usr/share/nginx/html/*

# Copy your static site content
COPY . /usr/share/nginx/html

# Expose port 80
EXPOSE 80
