# Tratamiento de datos
import pandas as pd
import numpy as np
# Gráficos
import seaborn as sns
import matplotlib.pyplot as plt
# Preprocesado y modelado
import scipy.stats as st
from sklearn import linear_model, metrics
from sklearn.metrics import r2_score
from sklearn.model_selection import train_test_split, KFold, cross_val_score
from sklearn.linear_model import LinearRegression, ElasticNet, Lasso, Ridge

urlTemp = 'dftemperatura.csv'
df = pd.read_csv(urlTemp, sep=";")
dftemperatura = df[['temperatura','duracion']].copy()
z = np.abs(st.zscore(dftemperatura))
dfTemperatura_clean=dftemperatura[(z<2).all(axis = 1)]
X_train,X_test,y_train,y_test = train_test_split(dfTemperatura_clean.temperatura.values.reshape(-1,1), dfTemperatura_clean.duracion.values, random_state=42)
reglin = LinearRegression()
reglin.fit(X=X_train,y=y_train)
prediccion = reglin.predict(X_test)
esperado = y_test
for p,e in zip(prediccion[0:10], esperado[0:10]):
    print(f'Prediccion: {p:.2f}, Esperado:{e:.2f}')
print("Coeficiente:",reglin.coef_)
print("Intercept:", reglin.intercept_)
print("Coeficiente de determinación R^2:",metrics.r2_score(esperado, prediccion))
print("Error cuadrático medio:",metrics.mean_squared_error(esperado, prediccion))
predice=(lambda x:reglin.coef_*x+reglin.intercept_)
estimadores = {
'RegLin': LinearRegression(),
'ElasticNet': ElasticNet(),
'Lasso': Lasso(),
'Ridge': Ridge()
}
for estimator_name, estimator_object in estimadores.items():
    kfold = KFold(n_splits=10, random_state=7, shuffle=True)
    scores = cross_val_score(estimator=estimator_object, X=dfTemperatura_clean.temperatura.values.reshape(-1,1), y=dfTemperatura_clean.duracion.values, cv=kfold, scoring='r2')
    print(f'{estimator_name:>16}: ' + f'Promedio de puntajes R2={scores.mean():.3f}')
