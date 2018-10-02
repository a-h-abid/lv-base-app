FROM adminer:4.6.3

# Add volume for sessions to allow session persistence
#VOLUME /sessions

# Set User
USER adminer

# We expose Adminer on port 8080 (Adminer's default)
EXPOSE 8080
