from django.contrib import admin
from .models import Category, Product, StockTransaction, EquipmentAllocation

# Register your models here.
admin.site.register(Category)
admin.site.register(Product)
admin.site.register(StockTransaction)
admin.site.register(EquipmentAllocation)
