from django.contrib import admin
from django.contrib.auth.admin import UserAdmin
from .models import CustomUser

class CustomUserAdmin(UserAdmin):
    model = CustomUser
    list_display = ("email", "username", "role", "department", "is_staff")
    search_fields = ("email", "username", "role")
    list_filter = ("role", "is_staff")
    fieldsets = (
        (None, {"fields": ("username", "email", "password")}),
        ("Permissions", {"fields": ("is_staff", "is_superuser")}),
        ("Personal Info", {"fields": ("role", "department")}),
    )

admin.site.register(CustomUser, CustomUserAdmin)
