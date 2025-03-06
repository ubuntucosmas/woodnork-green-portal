from django.db import models

# 1️⃣ Category Model (e.g., Office Equipment, Stationery)
class Category(models.Model):
    name = models.CharField(max_length=100, unique=True)

    def __str__(self):
        return self.name

# 2️⃣ Product Model (Linked to Category)
class Product(models.Model):
    UNIT_CHOICES = [
    ('pcs', 'Pieces'),
    ('kg', 'Kilograms'),
    ('liters', 'Liters'),
    ('meters', 'Meters'),
    ('boxes', 'Boxes'),
    ('packs', 'Packs'),
    ]
    
    STATUS_CHOICES = [
    ('available', 'Available'),
    ('out_of_stock', 'Out of Stock'),
    ('discontinued', 'Discontinued'),
    ]
    
    category = models.ForeignKey(Category, on_delete=models.CASCADE, related_name='products')
    name = models.CharField(max_length=200)
    description = models.TextField(blank=True, null=True)
    quantity = models.PositiveIntegerField(default=0)  # Stock level
    unit_of_measure = models.CharField(max_length=10, choices=UNIT_CHOICES, default='pcs')  # Added unit of measure
    price_per_unit = models.DecimalField(max_digits=10, decimal_places=2, default=0.00)  # New field for price
    created_at = models.DateTimeField(auto_now_add=True, null=True)  # Set once when the product is created
    status = models.CharField(max_length=15, choices=STATUS_CHOICES, default='available')  # New status field


    @property
    def total_price(self):
        return self.quantity * self.price_per_unit  # Calculate total price
    def __str__(self):
        return f"{self.name} ({self.quantity} {self.unit_of_measure}) - ${self.price_per_unit} per unit, Total: ${self.total_price}"

# 3️⃣ Stock Management Model (Track Stock Changes)
class StockTransaction(models.Model):
    product = models.ForeignKey(Product, on_delete=models.CASCADE, related_name='transactions')
    quantity = models.IntegerField()  # Positive for restock, negative for usage
    transaction_type = models.CharField(max_length=50, choices=[('IN', 'Restock'), ('OUT', 'Issued')])
    timestamp = models.DateTimeField(auto_now_add=True)

    def __str__(self):
        return f"{self.transaction_type} - {self.product.name} ({self.quantity})"

# 4️⃣ Equipment Allocation Model (Track who is using what)
class EquipmentAllocation(models.Model):
    product = models.ForeignKey(Product, on_delete=models.CASCADE, related_name='allocations')
    employee_name = models.CharField(max_length=150)
    department = models.CharField(max_length=150)
    allocated_date = models.DateField(auto_now_add=True)
    return_date = models.DateField(blank=True, null=True)

    def __str__(self):
        return f"{self.product.name} allocated to {self.employee_name}"
